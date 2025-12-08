<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Participant;
use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;

class AssessmentController extends Controller
{
    public function index()
    {
        // Get all participants for active period
        // For demo, hardcode period (or find active)
        $participants = Participant::all(); // Should filter by active period
        
        // Calculate progress for current user
        $userId = Auth::id();
        $participants->map(function ($p) use ($userId) {
            $count = Assessment::where('appraiser_id', $userId)
                        ->where('participant_id', $p->id)
                        ->count();
            // Total criteria count is 4 (K1, K2, K3, K4)
            $p->is_assessed = $count >= 4;
            return $p;
        });

        return Inertia::render('Assessments/Index', compact('participants'));
    }

    public function create(Participant $participant)
    {
        $criteria = Criteria::with('subCriteria')->get();
        
        // Check if existing assessment exists
        $assessments = Assessment::where('appraiser_id', Auth::id())
                        ->where('participant_id', $participant->id)
                        ->get()
                        ->keyBy('criteria_id');

        return Inertia::render('Assessments/Rate', compact('participant', 'criteria', 'assessments'));
    }

    public function store(Request $request, Participant $participant)
    {
        $criteria = Criteria::all();
        $rules = [];
        foreach ($criteria as $c) {
            $rules['criteria_' . $c->id] = 'required|integer';
        }

        $validated = $request->validate($rules);
        
        foreach ($criteria as $c) {
            $val = $validated['criteria_' . $c->id];
            
            // Find or Create Assessment
            Assessment::updateOrCreate(
                [
                    'appraiser_id' => Auth::id(),
                    'participant_id' => $participant->id,
                    'criteria_id' => $c->id,
                ],
                [
                    'value' => $val,
                    // Sub-criteria logic would go here if we were selecting sub-criteria IDs
                ]
            );
        }

        return redirect()->route('assessments.index')->with('success', 'Assessment saved.');
    }
}
