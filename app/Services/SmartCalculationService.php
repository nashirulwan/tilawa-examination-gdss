<?php

namespace App\Services;

use App\Models\Period;
use App\Models\Criteria;
use App\Models\User;
use App\Models\Assessment;
use App\Models\Participant;

class SmartCalculationService
{
    public function calculate(Period $period)
    {
        // 1. Prepare Criteria and Normalization
        $criteria = Criteria::all();
        $totalWeight = $criteria->sum('weight');
        $normalizedCriteria = $criteria->map(function ($c) use ($totalWeight) {
            $c->normalized_weight = $c->weight / $totalWeight;
            return $c;
        });

        // 2. Get Appraisers and Participants
        $participants = $period->participants;
        // Find appraisers who have assessed ANY participant in this period
        // Or simpler: Get all users with role 'appraiser' (assuming only assigned ones matter)
        // But better to rely on actual assessments to handle "who judged whom" or "all judged all"
        // Journal implies rigid set of appraisers.
        $appraisers = User::where('role', 'appraiser')->get();

        $results = [];

        foreach ($appraisers as $appraiser) {
            // Calculate Min/Max for each criterion for THIS appraiser
            // Check if appraiser has data
            $hasData = Assessment::where('appraiser_id', $appraiser->id)
                ->whereIn('participant_id', $participants->pluck('id'))
                ->exists();
                
            if (!$hasData) continue;

            $criteriaMinMax = [];
            foreach ($normalizedCriteria as $c) {
                 $values = Assessment::where('appraiser_id', $appraiser->id)
                    ->whereIn('participant_id', $participants->pluck('id'))
                    ->where('criteria_id', $c->id)
                    ->pluck('value');
                
                if ($values->isEmpty()) {
                    $criteriaMinMax[$c->id] = ['min' => 0, 'max' => 0];
                } else {
                    $criteriaMinMax[$c->id] = [
                        'min' => $values->min(),
                        'max' => $values->max(),
                    ];
                }
            }

            $participantScores = [];
            foreach ($participants as $p) {
                $totalSmart = 0;
                $details = [];

                foreach ($normalizedCriteria as $c) {
                    $assessment = Assessment::where('appraiser_id', $appraiser->id)
                        ->where('participant_id', $p->id)
                        ->where('criteria_id', $c->id)
                        ->first();
                    
                    $val = $assessment ? $assessment->value : 0; // Default to 0? Or skip?
                    
                    $min = $criteriaMinMax[$c->id]['min'];
                    $max = $criteriaMinMax[$c->id]['max'];
                    $diff = $max - $min;

                    // Utility Calculation
                    if ($diff == 0) {
                        // Max equals Min. 
                        // If Value == Max, utility is 100? Or 0?
                        // If all values are same, utility is 100 is reasonable as they all meet the "standard".
                        // However, usually if no variation, that criteria becomes irrelevant? 
                        // Let's assume 100 if value > 0?
                        $utility = ($val > 0) ? 100 : 0; 
                    } else {
                        $utility = 100 * ($val - $min) / $diff;
                    }

                    $score = $c->normalized_weight * $utility;
                    $totalSmart += $score;

                    $details[$c->code] = [
                        'value' => $val,
                        'utility' => $utility,
                        'weighted_score' => $score
                    ];
                }

                $participantScores[$p->id] = [
                    'participant' => $p,
                    'details' => $details,
                    'smart_score' => $totalSmart
                ];
            }

            // Sort by SMART score descending
            uasort($participantScores, function ($a, $b) {
                return $b['smart_score'] <=> $a['smart_score'];
            });

            // Assign Rank
            $rank = 1;
            foreach ($participantScores as &$ps) {
                $ps['rank'] = $rank++;
            }
            unset($ps);

            $results[$appraiser->id] = [
                'appraiser' => $appraiser,
                'participants' => $participantScores
            ];
        }

        return $results;
    }
}
