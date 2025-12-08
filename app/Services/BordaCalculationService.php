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

        // 2. Initialize Borda Points (only active participants)
        $participants = $period->participants()->where('is_active', true)->get();
        $bordaScores = [];
        foreach ($participants as $p) {
            $bordaScores[$p->id] = [
                'participant' => $p,
                'total_borda_score' => 0,
                'appraiser_details' => []
            ];
        }

        $N = $participants->count(); // Total participants = max Borda points for Rank 1
        
        foreach ($smartResults as $appraiserId => $data) {
            foreach ($data['participants'] as $pid => $pData) {
                // Skip if this participant is not in our active list
                if (!isset($bordaScores[$pid])) {
                    continue;
                }
                
                // Standard Borda: Rank 1 gets N points, Rank 2 gets N-1, etc.
                // Rank 1 → 5 pts, Rank 2 → 4 pts, ..., Rank 5 → 1 pt
                $bordaPoints = $N - $pData['rank'] + 1;
                
                // Just SUM the Borda points (NOT multiply by SMART score!)
                $bordaScores[$pid]['total_borda_score'] += $bordaPoints;
                $bordaScores[$pid]['appraiser_details'][$appraiserId] = [
                    'smart_score' => $pData['smart_score'],
                    'smart_details' => $pData['details'],
                    'rank' => $pData['rank'],
                    'borda_points' => $bordaPoints
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
