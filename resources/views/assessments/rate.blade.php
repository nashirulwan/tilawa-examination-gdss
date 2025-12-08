@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-weight: 700; margin: 0;">Rate: {{ $participant->name }}</h2>
        <a href="{{ route('assessments.index') }}" style="color: var(--text-muted);">Back to List</a>
    </div>

    <div class="glass" style="padding: 2rem;">
        <form method="POST" action="{{ route('assessments.store', $participant) }}">
            @csrf
            
            <div style="display: grid; gap: 2rem;">
                @foreach($criteria as $c)
                <div style="border-bottom: 1px solid var(--glass-border); padding-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <label style="font-weight: 600; font-size: 1.1rem;">{{ $c->name }} ({{ $c->code }})</label>
                        <span style="background: rgba(255,255,255,0.1); padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Weight: {{ $c->weight }}</span>
                    </div>

                    <!-- Simplified Value Input (Journal uses values directly, or sub-criteria) -->
                    <!-- For demo, let's use a slider or select for typical values -->
                    <!-- Sub-Criteria Options: Very precise (85), Appropriate (65), Not exactly (45), Very Incorrect (25) -->
                    
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                        @foreach($c->subCriteria as $sc)
                            <label style="display: flex; align-items: center; padding: 1rem; border: 1px solid var(--glass-border); border-radius: 8px; cursor: pointer; transition: 0.2s;" onclick="document.getElementById('val_{{ $c->id }}_{{ $sc->id }}').checked = true">
                                <input type="radio" 
                                    id="val_{{ $c->id }}_{{ $sc->id }}"
                                    name="criteria_{{ $c->id }}" 
                                    value="{{ $sc->value }}" 
                                    style="width: auto; margin-right: 0.5rem;"
                                    {{ (isset($assessments[$c->id]) && $assessments[$c->id]->value == $sc->value) ? 'checked' : '' }}
                                    required>
                                <div>
                                    <div style="font-weight: 500;">{{ $sc->name }}</div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">Value: {{ $sc->value }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <div style="margin-top: 2rem; text-align: right;">
                <button type="submit" class="btn-primary" style="font-size: 1.1rem; padding: 1rem 3rem;">Submit Assessment</button>
            </div>
        </form>
    </div>
</div>
@endsection
