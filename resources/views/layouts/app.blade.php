<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}"/>

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net"/>

  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"/>

  <!-- Scripts -->
  @vite([
    'resources/sass/app.scss',
    'resources/sass/dashboard.scss',
    'resources/js/app.js',
    'resources/js/dashboard.js'
  ])
</head>

<body class="sb-nav-fixed">
  <div id="app">

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
      <!-- Navbar Brand-->
      <a class="navbar-brand" href="{{ route('dashboard') }}">
        <img src="{{ asset('img/dinamika-white.png') }}" alt="logo undika" class="w-75 pt-3 ps-3">
      </a>
      <!-- Sidebar Toggle-->
      <button class="btn btn-link btn-sm order-1 order-lg-0 me-auto" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar-->
      @include('nav/navbar')

    </nav>
    <div id="layoutSidenav">
      @if (Route::has('login'))
        <div id="layoutSidenav_nav">
          @include('nav/sidenav')
        </div>
      @endif
      <div id="layoutSidenav_content">
        <main class="py-4">@yield('content')</main>
      </div>
    </div>
  </div>
</body>
</html>
