<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Collection;

class UtilityService
{
    
    public function cleaningData(array $fileData) : Collection
    {

        $maxColumnCount = collect($fileData)->map(fn($row) => count(array_filter($row)))->max();
        // Temukan baris pertama yang valid sebagai header
        $headerIndex = collect($fileData)->search(function ($row) use ($maxColumnCount) {
            return count(array_filter($row)) === $maxColumnCount;
        });
        
        if ($headerIndex === false || !isset($fileData[$headerIndex])) {
            throw new Exception("Tidak ditemukan baris header yang valid.");
        }

        $headers = array_map(fn($col) => strtolower(str_replace(" ","_", $col)), $fileData[$headerIndex]);
        $data = collect($fileData)
            ->skip($headerIndex+1)
            ->map(function($row) use ($headers) {
                $rowData = array_map(fn($col) => strtolower(preg_replace('/\s+/', ' ', trim($col))), $row);
                $indexOfMinute = array_search("min", $headers);
                $time = explode(":",$row[$indexOfMinute]);
                $timeInSecond = intval($time[0]) * 60 + intval($time[1]);

                $headers[] = "act_time";
                $rowData[] = $timeInSecond;

                return array_combine($headers, $rowData);
            });

        $dataSort = $data->sort(function($a, $b) use (&$data) {
            // Urutkan berdasar act_time
            if ($a['act_time'] !== $b['act_time']) {
                return $a['act_time'] <=> $b['act_time'];
            }

            //jika act_time sama cek team sebelumnya
            // cari baris sebelumnya (act_time lebih kecil)
            $prev = $data
                ->where('act_time', '<', $a['act_time'])
                ->sortByDesc('act_time')
                ->first();

            if ($prev) {
                if ($a['team'] === $prev['team']) return -1; // $a duluan
                if ($b['team'] === $prev['team']) return 1;  // $b duluan
            }

            return 0;
        });

        return $dataSort;
    }

    public function countTransition(Collection $data) : array
    {
        $teams = array_keys($data->groupBy('team')->toArray());
        $detail = [
            'attacking' => 0,
            'defending' => 0,
            'into_shot' => 0,
            'transition_shot' => 0,
            'total_shot' => 0,
            'into_goal' => 0,
            'logs' => [],
            'shot_logs' => [],
            'intoshot_logs' => null,
            'intogoal_logs' => null,
            'ct_zone' => []
        ];

        $transitionData = [
            $teams[0] => [...$detail],
            $teams[1] => [...$detail],
        ];
        
        $rowData = array_values($data->toArray());
        $invalidActions = ['throw in','goal kick','subs','foul','fouled','keeper','concede goal','free kick','tackle failed','yellow card','red card', 'intercept failed', 'header failed'];
        
        for ($i=0; $i < count($rowData); $i++) { 
            $row = $rowData[$i];
            $rowBefore = $i > 0 ? $rowData[$i-1] : null;
            $rowAfter = isset($rowData[$i+1]) ? $rowData[$i+1] : null;
            if(is_null($rowBefore))
                continue;
            if(is_null($rowAfter))
                continue;

            if(str_starts_with($row['action'], 'shoot')) {
                $transitionData[$row['team']]['total_shot'] += 1;
                $transitionData[$row['team']]['shot_logs'][] = [
                    'action' => $row['action'],
                    'action_time' => $row['min'],
                    'zone' => $row['act_zone'],
                    'actor' => $row['act_name'],
                    'team' => $row['team']
                ];
            }

            if($row['team'] !== $rowBefore['team'] && !in_array($row['action'], $invalidActions) && $row['min'] !== $rowBefore['min']) {

                if(($row['action'] == "offensive duel" || $row['action'] == "defensive duel") && $row['sub_1'] == 'lost')
                    continue;

                $defensiveThirdZone = [
                    '1a', '1b', '1c', '1d', '1e', '2a' , '2b',
                    '2c', '2d', '2e', '3a', '3b', '3c', '3d', '3e'
                ];
                $transitionData[$row['team']]['attacking'] += 1;
                $transitionData[$rowBefore['team']]['defending'] += 1;
                $zone = null;
                $hasIntoShoot = false;
                $hasIntoGoal = false;

                for ($j=$i+1; $j < count($rowData); $j++) { 
                    $finalThirdZone = ['5a','5b','5c','5d','5e','6a','6b','6c','6d','6e'];
                    $eventTracking = $rowData[$j];
                    if($row['team'] !== $eventTracking['team'])
                        break;

                    if($zone != $row['act_zone'] && in_array($row['act_zone'], $defensiveThirdZone) && in_array($eventTracking['act_zone'], $finalThirdZone)) {
                        $transitionData[$row['team']]['ct_zone'][] = $row['act_zone'];
                        $zone = $row['act_zone'];
                    }

                    $shotOrGoal = (str_starts_with($eventTracking['action'], 'shoot') || $eventTracking['action'] == 'goal');
                    if ($shotOrGoal && $this->intoShotValidate($eventTracking,$row['act_time'])) {

                        if($eventTracking['action'] == 'goal') {
                            $hasIntoGoal = true;
                            $transitionData[$eventTracking['team']]['into_goal'] += 1;
                            if (isset($transitionData[$eventTracking['team']]['intogoal_logs'][$row['act_zone']])) {
                                $transitionData[$eventTracking['team']]['intogoal_logs'][$row['act_zone']][] = $eventTracking['act_zone'];
                            } else {
                                $transitionData[$eventTracking['team']]['intogoal_logs'][$row['act_zone']] = [$eventTracking['act_zone']];
                            }

                            // $transitionData[$eventTracking['team']]['intogoal_logs'][] = [
                            //     'transition_time' => $row['min'],
                            //     'transition_sec' => $row['act_time'],
                            //     'action' => $eventTracking['action'],
                            //     'action_time' => $eventTracking['min'],
                            //     'action_sec' => $eventTracking['act_time'],
                            //     'zone' => $eventTracking['act_zone'],
                            //     'actor' => $eventTracking['act_name'],
                            //     'team' => $eventTracking['team']
                            // ];
                        } else {
                            $hasIntoShoot = true;
                            $transitionData[$eventTracking['team']]['transition_shot'] += 1;
                            $transitionData[$eventTracking['team']]['into_shot'] += 1;
                            if (isset($transitionData[$eventTracking['team']]['intoshot_logs'][$row['act_zone']])) {
                                $transitionData[$eventTracking['team']]['intoshot_logs'][$row['act_zone']][] = $eventTracking['act_zone'];
                            } else {
                                $transitionData[$eventTracking['team']]['intoshot_logs'][$row['act_zone']] = [$eventTracking['act_zone']];
                            }

                            // $transitionData[$eventTracking['team']]['intoshot_logs'][] = [
                            //     'transition_time' => $row['min'],
                            //     'transition_sec' => $row['act_time'],
                            //     'action' => $eventTracking['action'],
                            //     'action_time' => $eventTracking['min'],
                            //     'action_sec' => $eventTracking['act_time'],
                            //     'zone' => $eventTracking['act_zone'],
                            //     'actor' => $eventTracking['act_name'],
                            //     'team' => $eventTracking['team']
                            // ];
                        }
                        
                        break;
                    }

                    if(str_starts_with($eventTracking['action'], 'shoot')) {
                        $transitionData[$eventTracking['team']]['transition_shot'] += 1;
                        break;
                    }
                }

                $transitionData[$row['team']]['logs'][] = [
                    'transition_time' => $row['min'],
                    'transition' => "Positive Transition",
                    'action' => $row['action'],
                    'action_time' => $row['min'],
                    'zone' => $row['act_zone'],
                    'actor' => $row['act_name'],
                    'team' => $row['team'],
                    'into_shoot' => $hasIntoShoot,
                    'into_goal' => $hasIntoGoal
                ];

            }
        }

        return $transitionData;
    }

    private function intoShotValidate(array $row, int $transitionTime) : bool
    {
        $intoShotRules = [
            'final_third' => [
                'time' => 5,
                'zones' => ['5a','5b','5c','5d','5e','6a','6b','6c','6d','6e']
            ],
            'middle_third' => [
                'time' => 10,
                'zones' => ['3a','3b','3c','3d','3e','4a','4b','4c','4d','4e']
            ],
            'defensive_third' => [
                'time' => 15,
                'zones' => ['1a','1b','1c','1d','1e','2a','2b','2c','2d','2e']
            ]
        ];

        foreach ($intoShotRules as $key => $value) {
            $timeRange = $row['act_time'] - $transitionTime;
            if(in_array($row['act_zone'], $value['zones']) && $timeRange <= $value['time'])
                return true;
        }

        return false;
    }

}
