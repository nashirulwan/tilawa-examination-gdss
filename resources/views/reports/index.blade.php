@extends('layouts.app')

@section('content')
<div>
    <h2 style="margin-bottom: 2rem; font-weight: 700;">Final Rankings</h2>

    @if($period)
        <div class="glass" style="padding: 2rem; margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem;">Period: {{ $period->name }}</h3>
            
            <table>
                <thead>
                    <tr>
                        <th width="10%">Rank</th>
                        <th>Participant</th>
                        <th width="20%">Total Borda Points</th>
                        <th width="15%">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $res)
                        <tr>
                            <td>
                                <div style="width: 32px; height: 32px; background: {{ $res['final_rank'] <= 3 ? 'linear-gradient(135deg, #ffd700, #f59e0b)' : 'rgba(255,255,255,0.1)' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: {{ $res['final_rank'] <= 3 ? 'black' : 'white' }}">
                                    {{ $res['final_rank'] }}
                                </div>
                            </td>
                            <td>{{ $res['participant']->name }}</td>
                            <td>
                                <span style="font-size: 1.25rem; font-weight: 600;">
                                    {{ number_format($res['total_borda_score'], 2) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn-primary" style="padding: 6px 12px; font-size: 0.8rem;">View</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="glass" style="padding: 2rem;">
            <p>No active period found.</p>
        </div>
    @endif
</div>
@endsection
