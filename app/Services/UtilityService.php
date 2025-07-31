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
            })->sortBy('act_time');

        // $teams = array_keys($data->groupBy('team')->toArray());

        return $data;
    }

    public function countTransition(Collection $data) : array
    {
        $teams = array_keys($data->groupBy('team')->toArray());

        $transitionData = [
            $teams[0] => [
                'attacking' => 0,
                'defending' => 0,
                'into_shot' => 0,
                'total_shot' => 0,
                'logs' => [],
                'shot_logs' => [],
                'intoshot_logs' => []
            ],
            $teams[1] => [
                'attacking' => 0,
                'defending' => 0,
                'into_shot' => 0,
                'total_shot' => 0,
                'logs' => [],
                'shot_logs' => [],
                'intoshot_logs' => []
            ],
        ];
        
        $rowData = array_values($data->toArray());
        $invalidActions = ['throw in','goal kick','subs','foul','fouled','keeper','concede goal'];
        

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
                $transitionData[$row['team']]['attacking'] += 1;
                $transitionData[$rowBefore['team']]['defending'] += 1;
                $transitionData[$row['team']]['logs'][] = [
                    'transition_time' => $row['min'],
                    'transition' => "Positive Transition",
                    'action' => $row['action'],
                    'action_time' => $row['min'],
                    'zone' => $row['act_zone'],
                    'actor' => $row['act_name'],
                    'team' => $row['team']
                ];

                for ($j=$i+1; $j < count($rowData); $j++) { 
                    $eventTracking = $rowData[$j];
                    if($row['team'] !== $eventTracking['team'])
                        break;

                    if (str_starts_with($eventTracking['action'], 'shoot') && $this->intoShotValidate($eventTracking,$row['act_time'])) {

                        $transitionData[$eventTracking['team']]['into_shot'] += 1;
                        $transitionData[$eventTracking['team']]['intoshot_logs'][] = [
                            'transition_time' => $row['min'],
                            'transition_sec' => $row['act_time'],
                            'action' => $eventTracking['action'],
                            'action_time' => $eventTracking['min'],
                            'action_sec' => $eventTracking['act_time'],
                            'zone' => $eventTracking['act_zone'],
                            'actor' => $eventTracking['act_name'],
                            'team' => $eventTracking['team']
                        ];
                        
                        break;
                    }
                }

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
