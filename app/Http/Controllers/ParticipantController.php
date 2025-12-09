<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Period;
use Illuminate\Http\Request;

use Inertia\Inertia;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::with('period')->get();
        return Inertia::render('Participants/Index', compact('participants'));
    }

    public function create()
    {
        $periods = Period::where('is_active', true)->get();
        return Inertia::render('Participants/Create', compact('periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'gender' => 'required|in:male,female',
            'age' => 'nullable|integer|min:1|max:120',
            'department' => 'required',
            'period_id' => 'required|exists:periods,id',
            'is_active' => 'nullable|boolean',
        ]);

        Participant::create($validated);

        return redirect()->route('participants.index')->with('success', 'Participant created.');
    }

    public function edit(Participant $participant)
    {
        $periods = Period::all();
        return Inertia::render('Participants/Edit', compact('participant', 'periods'));
    }

    public function update(Request $request, Participant $participant)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required',
            'gender' => 'sometimes|required|in:male,female',
            'age' => 'sometimes|nullable|integer|min:1|max:120',
            'department' => 'sometimes|required',
            'period_id' => 'sometimes|required|exists:periods,id',
            'is_active' => 'sometimes|boolean',
        ]);

        $participant->update($validated);

        return redirect()->route('participants.index')->with('success', 'Participant updated.');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();
        return redirect()->route('participants.index')->with('success', 'Participant deleted.');
    }
}
