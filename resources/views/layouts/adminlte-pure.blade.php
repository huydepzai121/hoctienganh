<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin - Học Tiếng Anh')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  
  @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="https://via.placeholder.com/60x60/007bff/ffffff?text=HTA" alt="Logo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Trang chủ</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('home') }}" class="nav-link" target="_blank">Xem Website</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- User Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
          {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="{{ route('profile.edit') }}" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Hồ sơ
          </a>
          <div class="dropdown-divider"></div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item">
              <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
            </button>
          </form>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
      <img src="https://via.placeholder.com/33x33/007bff/ffffff?text=HTA" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Học Tiếng Anh</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ Auth::user()->avatar ?? 'https://via.placeholder.com/160x160/007bff/ffffff?text=' . substr(Auth::user()->name, 0, 1) }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('profile.edit') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          
          <li class="nav-header">QUẢN LÝ NỘI DUNG</li>
          <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tags"></i>
              <p>Danh Mục</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.courses.index') }}" class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book"></i>
              <p>Khóa Học</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.lessons.index') }}" class="nav-link {{ request()->routeIs('admin.lessons.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book-open"></i>
              <p>Bài Học</p>
            </a>
          </li>
          
          <li class="nav-header">QUẢN LÝ NGƯỜI DÙNG</li>
          <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>Người Dùng</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        @yield('content_header')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Alerts -->
        @if(session('success'))
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Thành công!</h5>
            {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
            {{ session('error') }}
          </div>
        @endif

        @if(session('warning'))
          <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Cảnh báo!</h5>
            {{ session('warning') }}
          </div>
        @endif

        @yield('content')
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{ route('home') }}">Học Tiếng Anh</a>.</strong>
    Tất cả quyền được bảo lưu.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')

<script>
  // Auto hide alerts after 5 seconds
  setTimeout(function() {
    $('.alert').fadeOut('slow');
  }, 5000);

  // Confirm delete actions
  $(document).on('click', '.btn-delete', function(e) {
    e.preventDefault();
    if (confirm('Bạn có chắc muốn xóa mục này?')) {
      $(this).closest('form').submit();
    }
  });
</script>
</body>
</html>
