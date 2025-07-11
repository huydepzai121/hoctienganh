@extends('adminlte::page')

@section('title', 'Admin - Học Tiếng Anh')

@section('content_header')
    @yield('page_header')
@stop

@section('content')
    @yield('page_content')
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <style>
        .content-wrapper {
            background: #f4f6f9;
        }
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            border: none;
        }
        .card-header {
            background: #fff;
            border-bottom: 1px solid #dee2e6;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
        }
        .badge {
            font-size: 0.75em;
        }
        .main-header .navbar {
            background: #fff;
            border-bottom: 1px solid #dee2e6;
        }
        .main-sidebar {
            background: #343a40;
        }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
            background-color: #007bff;
            color: #fff;
        }
        .content-header {
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }
        .stats-card-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            border-radius: 10px;
        }
        .stats-card-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border-radius: 10px;
        }
        .stats-card-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border-radius: 10px;
        }
    </style>
@stop

@section('js')
    {{-- Add here extra JavaScript --}}
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

        // DataTables initialization
        $(document).ready(function() {
            $('.data-table').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json'
                }
            });
        });
    </script>
@stop
