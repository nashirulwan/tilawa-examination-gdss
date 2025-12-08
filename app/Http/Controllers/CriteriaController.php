<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Http\Request;

use Inertia\Inertia;

class CriteriaController extends Controller
{
    public function index()
    {
        $criteria = Criteria::with('subCriteria')->get();
        return Inertia::render('Criteria/Index', compact('criteria'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:criteria',
            'name' => 'required',
            'weight' => 'required|integer',
        ]);

        Criteria::create($validated);

        return back()->with('success', 'Criteria created.');
    }

    public function update(Request $request, Criteria $criterion)
    {
        $validated = $request->validate([
            'code' => 'required|unique:criteria,code,' . $criterion->id,
            'name' => 'required',
            'weight' => 'required|integer',
        ]);

        $criterion->update($validated);

        return back()->with('success', 'Criteria updated.');
    }

    public function destroy(Criteria $criterion)
    {
        $criterion->delete();
        return back()->with('success', 'Criteria deleted.');
    }
}
