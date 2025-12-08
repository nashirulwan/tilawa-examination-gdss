@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="font-weight: 700; margin: 0;">Criteria Management</h2>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <!-- List -->
    <div class="glass" style="padding: 1.5rem;">
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Weight</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($criteria as $c)
                <tr>
                    <td>{{ $c->code }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->weight }}</td>
                    <td>
                        <!-- Edit simplified for demo, just delete -->
                        <form action="{{ route('criteria.destroy', $c) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer;">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Add Form -->
    <div class="glass" style="padding: 1.5rem; height: fit-content;">
        <h3 style="margin-bottom: 1rem;">Add Criteria</h3>
        <form method="POST" action="{{ route('criteria.store') }}">
            @csrf
            <div>
                <label>Code (e.g., K5)</label>
                <input type="text" name="code" required>
            </div>
            <div>
                <label>Name</label>
                <input type="text" name="name" required>
            </div>
            <div>
                <label>Weight</label>
                <input type="number" name="weight" required>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%;">Add</button>
        </form>
    </div>
</div>
@endsection
