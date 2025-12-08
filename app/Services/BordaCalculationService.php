<?php

namespace App\Services;

use App\Models\Period;
use App\Models\Participant;

class BordaCalculationService
{
    protected $smartService;

    public function __construct(SmartCalculationService $smartService)
    {
        $this->smartService = $smartService;
    }

    public function calculate(Period $period)
    {
        // 1. Get SMART Results
        $smartResults = $this->smartService->calculate($period);

        // 2. Initialize Borda Points
        $participants = $period->participants;
        $bordaScores = [];
        foreach ($participants as $p) {
            $bordaScores[$p->id] = [
                'participant' => $p,
                'total_borda_score' => 0,
                'appraiser_details' => []
            ];
        }

        $N = $participants->count(); // Total participants, effectively the max points (Rank 1 gets N points? or 5 points fixed? Journal says n=5).
        // Journal: "Poin Borda didasarkan pada urutan (n=5, n-1, n-2, ...)" where n is number of participants? Yes "P1 (Peringkat 1) 100 5 500". 100 is SMART, 5 is Borda points. 500 is total points?
        // Wait. A1: P1 SMART=100. Poin=5. Total=500.
        // A1: P5 SMART=72. Poin=4. Total=288.
        // The journal aggregates "Total Points (SMART * Borda)".
        // And Final Ranking is based on "Total Points (Borda)".
        // So the algorithm is: Sum(SMART_Score * RankWeight) across all appraisers?
        // Let's check Final Result.
        // P1: A1(500) + A2(280) = 780.
        // A2 P1: SMART=70.5. Rank 2. Points 4. Total=282 (70.5 * 4 = 282).
        // Journal says 280. 282 vs 280. Difference is 2 points. Maybe 70.0? Normalized weights rounding?
        // I will implement Sum(SMART * RankWeight).
        
        foreach ($smartResults as $appraiserId => $data) {
            foreach ($data['participants'] as $pid => $pData) {
                // Rank Weight: N - Rank + 1. (Rank 1 -> N, Rank N -> 1).
                // Example N=5. Rank 1: 5-1+1 = 5. Rank 5: 5-5+1 = 1.
                $rankWeight = $N - $pData['rank'] + 1;
                
                // Calculate Points
                $points = $pData['smart_score'] * $rankWeight;
                
                $bordaScores[$pid]['total_borda_score'] += $points;
                $bordaScores[$pid]['appraiser_details'][$appraiserId] = [
                    'smart_score' => $pData['smart_score'],
                    'rank' => $pData['rank'],
                    'borda_weight' => $rankWeight,
                    'points' => $points
                ];
            }
        }

        // Sort Final Results
        uasort($bordaScores, function ($a, $b) {
            return $b['total_borda_score'] <=> $a['total_borda_score'];
        });

        // Assign Final Rank
        $rank = 1;
        $finalResults = [];
        foreach ($bordaScores as $pid => $data) {
            $data['final_rank'] = $rank++;
            $finalResults[] = $data;
        }

        return $finalResults;
    }
}
