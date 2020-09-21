<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CRM @yield('title')</title>

  <meta name="csrf_token" content="{{ csrf_token() }}" />

  @include('layout.styles')
 
<script>
    var BASE_URL = '{{ url("/") }}';
</script>

  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    @include('layout.header')
    @include('layout.sidebar')

    <div class="content-wrapper">

      @yield('content')
      
    </div>

    <footer class="main-footer">
      <strong>Copyright &copy; {{ date('Y') }} </strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.
      </div>
    </footer>

    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  @include('layout.footer')

  @yield('scripts')

</body>
</html>