@extends('layouts.adminlte-pure')

@section('title', 'Chi Tiết Bài Học - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Chi Tiết Bài Học</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.lessons.index') }}">Bài Học</a></li>
                <li class="breadcrumb-item active">Chi Tiết</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $lesson->title }}</h3>
                    <div class="card-tools">
                        @if($lesson->is_published)
                            <span class="badge badge-success">Đã xuất bản</span>
                        @else
                            <span class="badge badge-secondary">Nháp</span>
                        @endif
                        @if($lesson->is_free)
                            <span class="badge badge-info">Miễn phí</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($lesson->video_url)
                        <div class="embed-responsive embed-responsive-16by9 mb-3">
                            @if(str_contains($lesson->video_url, 'youtube.com') || str_contains($lesson->video_url, 'youtu.be'))
                                @php
                                    $videoId = '';
                                    if (str_contains($lesson->video_url, 'youtube.com/watch?v=')) {
                                        $videoId = substr($lesson->video_url, strpos($lesson->video_url, 'v=') + 2);
                                    } elseif (str_contains($lesson->video_url, 'youtu.be/')) {
                                        $videoId = substr($lesson->video_url, strrpos($lesson->video_url, '/') + 1);
                                    }
                                @endphp
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $videoId }}" allowfullscreen></iframe>
                            @else
                                <iframe class="embed-responsive-item" src="{{ $lesson->video_url }}" allowfullscreen></iframe>
                            @endif
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">ID</th>
                            <td>{{ $lesson->id }}</td>
                        </tr>
                        <tr>
                            <th>Tiêu đề</th>
                            <td>{{ $lesson->title }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td><code>{{ $lesson->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Khóa học</th>
                            <td>
                                <a href="{{ route('admin.courses.show', $lesson->course) }}">
                                    {{ $lesson->course->title }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Danh mục</th>
                            <td>
                                <span class="badge badge-info">{{ $lesson->course->category->name }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Tóm tắt</th>
                            <td>{{ $lesson->summary }}</td>
                        </tr>
                        <tr>
                            <th>Thời lượng</th>
                            <td>{{ $lesson->duration_minutes }} phút</td>
                        </tr>
                        <tr>
                            <th>Thứ tự</th>
                            <td>{{ $lesson->order }}</td>
                        </tr>
                        <tr>
                            <th>Video URL</th>
                            <td>
                                @if($lesson->video_url)
                                    <a href="{{ $lesson->video_url }}" target="_blank">{{ $lesson->video_url }}</a>
                                @else
                                    Không có video
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Trạng thái</th>
                            <td>
                                @if($lesson->is_published)
                                    <span class="badge badge-success">Đã xuất bản</span>
                                @else
                                    <span class="badge badge-secondary">Nháp</span>
                                @endif
                                @if($lesson->is_free)
                                    <span class="badge badge-info ml-1">Miễn phí</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Học viên hoàn thành</th>
                            <td>{{ $lesson->completedUsers()->count() }} người</td>
                        </tr>
                        <tr>
                            <th>Ngày tạo</th>
                            <td>{{ $lesson->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối</th>
                            <td>{{ $lesson->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <h5>Nội dung bài học:</h5>
                        <div class="border p-3 bg-light">
                            {!! nl2br(e($lesson->content)) !!}
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <a href="{{ route('admin.lessons.edit', $lesson) }}" class="btn btn-primary">
                        <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list mr-2"></i>Danh sách
                    </a>
                    <a href="{{ route('lessons.show', $lesson->slug) }}" class="btn btn-info" target="_blank">
                        <i class="fas fa-external-link-alt mr-2"></i>Xem trên website
                    </a>
                    <form method="POST" action="{{ route('admin.lessons.destroy', $lesson) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-delete">
                            <i class="fas fa-trash mr-2"></i>Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Học viên đã hoàn thành</h3>
                </div>
                <div class="card-body">
                    @php
                        $completedUsers = $lesson->completedUsers()->with('user')->take(10)->get();
                    @endphp
                    
                    @if($completedUsers->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($completedUsers as $completion)
                                <div class="list-group-item d-flex align-items-center">
                                    <img src="{{ $completion->user->avatar ?? 'https://via.placeholder.com/32x32/007bff/ffffff?text=' . substr($completion->user->name, 0, 1) }}" 
                                         class="img-circle mr-2" width="32" height="32" alt="{{ $completion->user->name }}">
                                    <div>
                                        <strong>{{ $completion->user->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $completion->completed_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($lesson->completedUsers()->count() > 10)
                            <div class="text-center mt-3">
                                <small class="text-muted">Và {{ $lesson->completedUsers()->count() - 10 }} người khác</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <p>Chưa có học viên nào hoàn thành</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bài học khác trong khóa học</h3>
                </div>
                <div class="card-body">
                    @php
                        $otherLessons = $lesson->course->lessons()->where('id', '!=', $lesson->id)->orderBy('order')->take(5)->get();
                    @endphp
                    
                    @if($otherLessons->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($otherLessons as $otherLesson)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $otherLesson->order }}. {{ Str::limit($otherLesson->title, 25) }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $otherLesson->duration_minutes }} phút</small>
                                        </div>
                                        <div>
                                            @if($otherLesson->is_published)
                                                <span class="badge badge-success">Đã xuất bản</span>
                                            @else
                                                <span class="badge badge-secondary">Nháp</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted">
                            <p>Không có bài học khác</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
