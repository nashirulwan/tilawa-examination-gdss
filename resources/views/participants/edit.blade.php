@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <h2 style="margin-bottom: 2rem;">Edit Participant</h2>
    <div class="glass" style="padding: 2rem;">
        <form method="POST" action="{{ route('participants.update', $participant) }}">
            @csrf
            @method('PUT')
            <div>
                <label>Name</label>
                <input type="text" name="name" value="{{ $participant->name }}" required>
            </div>
            <div>
                <label>Gender</label>
                <select name="gender" style="width: 100%; padding: 12px; margin-bottom: 1rem; background: rgba(0,0,0,0.2); border: 1px solid var(--glass-border); color: white; border-radius: 8px;">
                    <option value="male" {{ $participant->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $participant->gender == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div>
                <label>Period</label>
                <select name="period_id" style="width: 100%; padding: 12px; margin-bottom: 1rem; background: rgba(0,0,0,0.2); border: 1px solid var(--glass-border); color: white; border-radius: 8px;">
                    @foreach($periods as $period)
                        <option value="{{ $period->id }}" {{ $participant->period_id == $period->id ? 'selected' : '' }}>{{ $period->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-primary">Update Participant</button>
        </form>
    </div>
</div>
@endsection
