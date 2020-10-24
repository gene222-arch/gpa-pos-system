
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <link rel="stylesheet" href="{{ asset('css/app.css')}}">
  <link rel="stylesheet" href="{{ asset('css/custom.css')}}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  @yield('css')
  <script>
      window.APP = <?php echo json_encode([ 'currency_symbol' => config('settings.currency_symbol') ]) ?>
  </script>
</head>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  @include('includes.navbar')
  <!-- Navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    @include('includes.sidebar')
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="container mt-2">
      <div class="row">
        <div class="col-md-6">
          <h1>@yield('content-header')</h1>
        </div>
        <div class="col-md-6 text-right">
          @yield('content-actions')
        </div>
      </div>
    </div>

{{-- Main Content --}}
    <section class="content my-4">
      @include('messages.action_message')
      @yield('content')
    </section>

  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    @include('includes.footer')
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('js/app.js') }}"></script>

@yield('js')
</body>
</html>
