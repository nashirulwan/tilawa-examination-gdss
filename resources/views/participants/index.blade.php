@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="font-weight: 700; margin: 0;">Participant Management</h2>
    <a href="{{ route('participants.create') }}" class="btn-primary">Add Participant</a>
</div>

<div class="glass" style="padding: 1.5rem;">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>Period</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participants as $p)
            <tr>
                <td>{{ $p->name }}</td>
                <td>{{ ucfirst($p->gender) }}</td>
                <td>{{ $p->period->name }} ({{ $p->period->year }})</td>
                <td>
                    <a href="{{ route('participants.edit', $p) }}" style="color: var(--primary);">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
