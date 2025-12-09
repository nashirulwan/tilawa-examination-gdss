<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\User;
use App\Models\Participant;
use App\Models\Assessment;
use App\Services\BordaCalculationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JuryChairController extends Controller
{
    protected $bordaService;

    public function __construct(BordaCalculationService $bordaService)
    {
        $this->bordaService = $bordaService;
    }

    public function index()
    {
        $period = Period::where('is_active', true)->first();
        
        // Get assessment status per appraiser
        $appraisers = User::where('role', 'appraiser')
            ->where('is_active', true)
            ->get()
            ->map(function ($appraiser) use ($period) {
                $totalParticipants = $period ? Participant::where('period_id', $period->id)
                    ->where('is_active', true)
                    ->count() : 0;
                
                $assessedCount = $period ? Assessment::where('appraiser_id', $appraiser->id)
                    ->whereHas('participant', fn($q) => $q->where('period_id', $period->id))
                    ->distinct('participant_id')
                    ->count('participant_id') : 0;

                return [
                    'id' => $appraiser->id,
                    'name' => $appraiser->name,
                    'assessed' => $assessedCount,
                    'total' => $totalParticipants,
                    'completed' => $assessedCount >= $totalParticipants && $totalParticipants > 0
                ];
            });

        // Check if all appraisers have completed
        $allCompleted = $appraisers->every(fn($a) => $a['completed']);

        // Get cached Borda results if available
        $bordaResults = session('borda_results');

        return Inertia::render('JuryChair/Index', [
            'period' => $period,
            'appraisers' => $appraisers,
            'allCompleted' => $allCompleted,
            'bordaResults' => $bordaResults
        ]);
    }

    public function calculate()
    {
        $period = Period::where('is_active', true)->first();

        if (!$period) {
            return redirect()->back()->with('error', 'No active period found.');
        }

        // Perform Borda calculation
        $results = $this->bordaService->calculate($period);

        // Store results in session (or could store in database for persistence)
        session(['borda_results' => array_values($results)]);

        return redirect()->route('jury-chair.index')->with('success', 'Borda calculation completed successfully.');
    }
}
