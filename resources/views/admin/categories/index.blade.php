@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Quản Lý Danh Mục</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm Danh Mục
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Slug</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                <div class="fw-bold">{{ $category->name }}</div>
                            </td>
                            <td>
                                <code>{{ $category->slug }}</code>
                            </td>
                            <td>{{ Str::limit($category->description, 50) }}</td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-secondary">Tạm dừng</span>
                                @endif
                            </td>
                            <td>{{ $category->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">
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
                    <i class="fas fa-plus me-2"></i>Tạo Danh Mục Đầu Tiên
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
