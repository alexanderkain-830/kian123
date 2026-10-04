<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dash Coffee POS')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="app">

        <aside class="sidebar">
            <div class="sidebar-user">
                <span class="avatar"></span>
                <span>Owner</span>
            </div>

            <nav>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dash board</a>
                <a href="{{ route('order-entry') }}" class="{{ request()->routeIs('order-entry') ? 'active' : '' }}">Order entry</a>
                <a href="{{ route('manage-menu') }}" class="{{ request()->routeIs('manage-menu') ? 'active' : '' }}">Manage menu</a>
                <a href="{{ route('inventory') }}" class="{{ request()->routeIs('inventory') ? 'active' : '' }}">Inventory</a>
                <a href="{{ route('sales-report') }}" class="{{ request()->routeIs('sales-report') ? 'active' : '' }}">Sales report</a>
                <a href="{{ route('staff') }}" class="{{ request()->routeIs('staff') ? 'active' : '' }}">Staff</a>
            </nav>

            <a href="{{ route('login') }}" class="logout">Log out</a>
        </aside>

        <main class="main @yield('main-class')">
            @yield('content')
        </main>

    </div>

    @stack('modals')
    @stack('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
