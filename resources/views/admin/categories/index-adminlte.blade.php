@extends('layouts.adminlte-pure')

@section('title', 'Quản Lý Danh Mục - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Quản Lý Danh Mục</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Danh Mục</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh Sách Danh Mục</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i>Thêm Danh Mục
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($categories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">ID</th>
                                        <th>Tên</th>
                                        <th>Slug</th>
                                        <th>Mô tả</th>
                                        <th style="width: 100px">Trạng thái</th>
                                        <th style="width: 100px">Ngày tạo</th>
                                        <th style="width: 150px">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>
                                            <div class="font-weight-bold">{{ $category->name }}</div>
                                        </td>
                                        <td>
                                            <code>{{ $category->slug }}</code>
                                        </td>
                                        <td>{{ Str::limit($category->description, 50) }}</td>
                                        <td>
                                            @if($category->is_active)
                                                <span class="badge badge-success">Hoạt động</span>
                                            @else
                                                <span class="badge badge-secondary">Tạm dừng</span>
                                            @endif
                                        </td>
                                        <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $categories->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tags fa-5x text-muted mb-4"></i>
                            <h4>Chưa có danh mục nào</h4>
                            <p class="text-muted">Hãy tạo danh mục đầu tiên cho website của bạn</p>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i>Tạo Danh Mục Đầu Tiên
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable if needed
    $('.table').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
        }
    });
});
</script>
@endpush
