@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <h2 style="margin-bottom: 2rem;">Add Participant</h2>
    <div class="glass" style="padding: 2rem;">
        <form method="POST" action="{{ route('participants.store') }}">
            @csrf
            <div>
                <label>Name</label>
                <input type="text" name="name" required>
            </div>
            <div>
                <label>Gender</label>
                <select name="gender" style="width: 100%; padding: 12px; margin-bottom: 1rem; background: rgba(0,0,0,0.2); border: 1px solid var(--glass-border); color: white; border-radius: 8px;">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div>
                <label>Period</label>
                <select name="period_id" style="width: 100%; padding: 12px; margin-bottom: 1rem; background: rgba(0,0,0,0.2); border: 1px solid var(--glass-border); color: white; border-radius: 8px;">
                    @foreach($periods as $period)
                        <option value="{{ $period->id }}">{{ $period->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-primary">Save Participant</button>
        </form>
    </div>
</div>
@endsection
