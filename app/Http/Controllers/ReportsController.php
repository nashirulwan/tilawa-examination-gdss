<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
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

        return Inertia::render('Reports/Index', [
            'results' => $results,
            'period' => $period
        ]);
    }

    public function show($participantId)
    {
        // Placeholder for detailed calculation view
        // In a real app, you would fetch specific calculation steps here
        return Inertia::render('Reports/Show', [
             'participant_id' => $participantId,
             // Add detailed steps data here
        ]);
    }
}
