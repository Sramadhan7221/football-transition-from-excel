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
                'logs' => []
            ],
            $teams[1] => [
                'attacking' => 0,
                'defending' => 0,
                'into_shot' => 0,
                'logs' => []
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

            if($row['team'] !== $rowBefore['team'] && !in_array($row['action'], $invalidActions) && $row['min'] !== $rowBefore['min']) {
                $transitionData[$row['team']]['attacking'] += 1;
                $transitionData[$rowBefore['team']]['defending'] += 1;
                $logAction = [];

                for ($j=$i+1; $j < count($rowData); $j++) { 
                    $eventTracking = $rowData[$j];
                    if($row['team'] !== $eventTracking['team'])
                        break;

                    if (str_starts_with($eventTracking['action'], 'shoot')) {
                        $transitionData[$eventTracking['team']]['into_shot'] += 1;
                        $logAction[] = [
                            'transition_time' => $row['min'],
                            // 'transition_act_time' => $row['act_time'],
                            'action' => $eventTracking['action'],
                            'action_time' => $eventTracking['min'],
                            // 'action_act_time' => $eventTracking['act_time'],
                            'zone' => $eventTracking['act_zone'],
                            'actor' => $eventTracking['act_name'],
                            'team' => $eventTracking['team']
                        ];
                        
                        // break;
                    }
                }

                if(empty($logAction)) {
                    $logAction[] = [
                        'transition_time' => $row['min'],
                        // 'transition_act_time' => $row['act_time'],
                        'action' => $row['action'],
                        'action_time' => $row['min'],
                        // 'action_act_time' => $row['act_time'],
                        'zone' => $row['act_zone'],
                        'actor' => $row['act_name'],
                        'team' => $row['team']
                    ];
                }

                foreach ($logAction as $value) {
                    $transitionData[$row['team']]['logs'][] = $value;
                }
            }
        }

        return $transitionData;
    }
}
