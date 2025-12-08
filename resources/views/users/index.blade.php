@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="font-weight: 700; margin: 0;">User Management</h2>
    <a href="{{ route('users.create') }}" class="btn-primary">Add User</a>
</div>

<div class="glass" style="padding: 1.5rem;">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span style="padding: 4px 8px; border-radius: 4px; background: rgba(255, 255, 255, 0.1); font-size: 0.8rem;">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('users.edit', $user) }}" style="color: var(--primary); margin-right: 1rem;">Edit</a>
                    <!-- Form for delete should be here, simplified for demo -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
