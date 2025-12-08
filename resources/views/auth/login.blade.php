@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="glass" style="padding: 3rem; width: 100%; max-width: 400px; text-align: center;">
        <h2 style="margin-bottom: 2rem;">Welcome Back</h2>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div style="margin-bottom: 1rem; text-align: left;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Email</label>
                <input type="email" name="email" required autofocus value="admin@mtq.com">
            </div>

            <div style="margin-bottom: 2rem; text-align: left;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Password</label>
                <input type="password" name="password" required value="password">
            </div>

            <button type="submit" class="btn-primary" style="width: 100%;">
                Sign In
            </button>
        </form>
        
        <div style="margin-top: 1rem; font-size: 0.875rem; color: var(--text-muted);">
            <p>Demo Accounts:</p>
            <p>Admin: admin@mtq.com / password</p>
            <p>Appraiser: appraiser1@mtq.com / password</p>
        </div>
    </div>
</div>
@endsection
