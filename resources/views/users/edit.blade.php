@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <h2 style="margin-bottom: 2rem;">Edit User: {{ $user->name }}</h2>
    <div class="glass" style="padding: 2rem;">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')
            <div>
                <label>Name</label>
                <input type="text" name="name" value="{{ $user->name }}" required>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required>
            </div>
            <div>
                <label>Role</label>
                <select name="role" style="width: 100%; padding: 12px; margin-bottom: 1rem; background: rgba(0,0,0,0.2); border: 1px solid var(--glass-border); color: white; border-radius: 8px;">
                    <option value="appraiser" {{ $user->role == 'appraiser' ? 'selected' : '' }}>Appraiser</option>
                    <option value="committee" {{ $user->role == 'committee' ? 'selected' : '' }}>Committee</option>
                </select>
            </div>
            <div>
                <label>Password (Leave blank to keep current)</label>
                <input type="password" name="password">
            </div>
            <button type="submit" class="btn-primary">Update User</button>
        </form>
    </div>
</div>
@endsection
