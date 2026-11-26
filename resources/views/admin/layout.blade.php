<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="@yield('favicon', config('cakrawala.brand.logo'))" type="image/x-icon">
    <title>@yield('title', 'Admin') | {{ config('cakrawala.brand.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
    <div class="admin-layout">
            {{-- SIDEBAR --}}
        @include('admin.partials.sidebar')
<main class="admin-main @yield('main-class')">
    @yield('content')
</main>
    </div>
</body>
</html>