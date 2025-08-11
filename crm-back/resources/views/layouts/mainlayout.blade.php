<!doctype html>
<html lang="en">

<head>
  @include('layouts.partials.head')
</head>



  
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!-- Menu -->

           @include('layouts.partials.nav')

        @include('layouts.partials.header')
        <!-- / Menu -->

         

         @yield('content')
          <!-- / Navbar -->

           @include('layouts.partials.footer')
            <!-- / Footer -->
  </div>

</div>
    

    @include('layouts.partials.footer-scripts')

    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
