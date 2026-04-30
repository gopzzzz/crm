<!doctype html>
<html lang="en">
<head>
  @include('layouts.partials.head')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <div class="app-wrapper">

    @include('layouts.partials.nav')
    @include('layouts.partials.header')

    @yield('content')

    @include('layouts.partials.footer')

  </div>

  @include('layouts.partials.footer-scripts')
</body>
</html>