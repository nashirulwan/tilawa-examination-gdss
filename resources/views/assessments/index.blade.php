@extends('layouts.app')

@section('content')
<h2 style="margin-bottom: 2rem; font-weight: 700;">Rate Participants</h2>

<div class="glass" style="padding: 1.5rem;">
    <table>
        <thead>
            <tr>
                <th>Participant</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participants as $p)
            <tr>
                <td>{{ $p->name }}</td>
                <td>
                    @if($p->is_assessed)
                        <span style="color: #10b981; font-weight: 600;">Completed</span>
                    @else
                        <span style="color: var(--text-muted);">Pending</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('assessments.rate', $p) }}" class="btn-primary" style="padding: 8px 16px; font-size: 0.9rem;">
                        {{ $p->is_assessed ? 'Update Rating' : 'Rate Now' }}
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
