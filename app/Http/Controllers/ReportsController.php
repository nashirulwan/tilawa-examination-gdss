<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Participant;
use App\Services\BordaCalculationService;

use Inertia\Inertia;

class ReportsController extends Controller
{
    protected $calculator;

    public function __construct(BordaCalculationService $calculator)
    {
        $this->calculator = $calculator;
    }

    public function index()
    {
        // For demo, hardcode 2021 period
        $period = Period::where('year', 2021)->first();
        if (!$period) {
            return Inertia::render('Reports/Index', ['results' => [], 'period' => null]);
        }

        $results = $this->calculator->calculate($period);
        
        // Enhance results with Average SMART Score
        foreach ($results as &$res) {
            $smartScores = collect($res['appraiser_details'])->pluck('smart_score');
            $res['average_smart'] = $smartScores->avg();
        }
        unset($res);

        // Department Stats (Demographics)
        $demographics = Participant::select('department', \DB::raw('count(*) as total'))
            ->where('period_id', $period->id)
            ->groupBy('department')
            ->get();

        return Inertia::render('Reports/Index', [
            'results' => $results,
            'period' => $period,
            'demographics' => $demographics
        ]);
    }

    public function show($participantId)
    {
        // 1. Calculate everything (simplest way to ensure consistency)
        $period = Period::where('year', 2021)->first(); // Hardcoded for demo
        if (!$period) abort(404);

        $results = $this->calculator->calculate($period);
        $allScores = collect($results)->pluck('total_borda_score');
        
        // 2. Find specific participant
        $participantResult = collect($results)->first(function ($item) use ($participantId) {
            return $item['participant']->id == $participantId;
        });

        if (!$participantResult) abort(404);

        // 3. Prepare Stats
        $stats = [
            'class_average' => $allScores->avg(),
            'max_score' => $allScores->max(),
            'min_score' => $allScores->min(),
            'total_participants' => $allScores->count(),
        ];
        
        // 4. Get Appraiser Names for the details view
        $appraisers = \App\Models\User::whereIn('id', array_keys($participantResult['appraiser_details']))->pluck('name', 'id');

        return Inertia::render('Reports/Show', [
             'participant_result' => $participantResult,
             'stats' => $stats,
             'appraisers' => $appraisers
        ]);
    }
}
