<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MTQ GDSS') }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /* Minimal reset included in app.css or here */
    </style>
</head>
<body>
    <div id="app" class="layout-container">
        @auth
            <aside class="sidebar glass">
                <div style="margin-bottom: 2rem;">
                    <h1 style="font-size: 1.5rem; font-weight: 700; background: linear-gradient(to right, #4f46e5, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">MTQ System</h1>
                </div>
                <nav>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    @if(auth()->user()->role == 'committee')
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">Users</a>
                        <a href="{{ route('participants.index') }}" class="nav-link {{ request()->routeIs('participants.*') ? 'active' : '' }}">Participants</a>
                        <a href="{{ route('criteria.index') }}" class="nav-link {{ request()->routeIs('criteria.*') ? 'active' : '' }}">Criteria</a>
                        <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}">Reports</a>
                    @else
                        <a href="{{ route('assessments.index') }}" class="nav-link {{ request()->routeIs('assessments.*') ? 'active' : '' }}">Rate Participants</a>
                        <a href="#" class="nav-link">My Profile</a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" style="margin-top: auto;">
                        @csrf
                        <button type="submit" class="nav-link" style="background:none; border:none; width:100%; cursor:pointer;">
                            Logout
                        </button>
                    </form>
                </nav>
            </aside>
        @endauth

        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>
