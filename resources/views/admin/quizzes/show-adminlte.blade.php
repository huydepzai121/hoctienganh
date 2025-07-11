@extends('layouts.adminlte-pure')

@section('title', 'Chi Tiết Quiz - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Chi Tiết Quiz</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.index') }}">Quiz</a></li>
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
                    <h3 class="card-title">{{ $quiz->title }}</h3>
                    <div class="card-tools">
                        @if($quiz->is_active)
                            <span class="badge badge-success">Hoạt động</span>
                        @else
                            <span class="badge badge-secondary">Tạm dừng</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">ID</th>
                            <td>{{ $quiz->id }}</td>
                        </tr>
                        <tr>
                            <th>Tiêu đề</th>
                            <td>{{ $quiz->title }}</td>
                        </tr>
                        <tr>
                            <th>Mô tả</th>
                            <td>{{ $quiz->description ?: 'Không có mô tả' }}</td>
                        </tr>
                        <tr>
                            <th>Bài học</th>
                            <td>
                                @if($quiz->lesson)
                                    <a href="{{ route('admin.lessons.show', $quiz->lesson) }}">
                                        {{ $quiz->lesson->title }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Khóa học</th>
                            <td>
                                @if($quiz->lesson && $quiz->lesson->course)
                                    <a href="{{ route('admin.courses.show', $quiz->lesson->course) }}">
                                        {{ $quiz->lesson->course->title }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Số câu hỏi</th>
                            <td>{{ $quiz->questions->count() }} câu</td>
                        </tr>
                        <tr>
                            <th>Thời gian làm bài</th>
                            <td>
                                @if($quiz->time_limit)
                                    {{ $quiz->time_limit }} phút
                                @else
                                    <span class="text-muted">Không giới hạn</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Số lần làm tối đa</th>
                            <td>{{ $quiz->max_attempts }} lần</td>
                        </tr>
                        <tr>
                            <th>Điểm đạt</th>
                            <td>{{ $quiz->passing_score }}%</td>
                        </tr>
                        <tr>
                            <th>Trạng thái</th>
                            <td>
                                @if($quiz->is_active)
                                    <span class="badge badge-success">Hoạt động</span>
                                @else
                                    <span class="badge badge-secondary">Tạm dừng</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Ngày tạo</th>
                            <td>{{ $quiz->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối</th>
                            <td>{{ $quiz->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
                
                <div class="card-footer">
                    <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-primary">
                        <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list mr-2"></i>Danh sách
                    </a>
                    <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-delete">
                            <i class="fas fa-trash mr-2"></i>Xóa
                        </button>
                    </form>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Câu hỏi trong Quiz</h3>
                    <div class="card-tools">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i>Thêm câu hỏi
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($quiz->questions->count() > 0)
                        @foreach($quiz->questions as $question)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="card-title">
                                        Câu {{ $question->order }}: 
                                        @switch($question->type)
                                            @case('multiple_choice')
                                                <span class="badge badge-primary">Trắc nghiệm</span>
                                                @break
                                            @case('true_false')
                                                <span class="badge badge-info">Đúng/Sai</span>
                                                @break
                                            @case('fill_blank')
                                                <span class="badge badge-warning">Điền chỗ trống</span>
                                                @break
                                            @case('essay')
                                                <span class="badge badge-success">Tự luận</span>
                                                @break
                                        @endswitch
                                        <span class="badge badge-secondary">{{ $question->points }} điểm</span>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Câu hỏi:</strong> {{ $question->question }}</p>
                                    
                                    @if($question->type === 'multiple_choice' && $question->options)
                                        <p><strong>Lựa chọn:</strong></p>
                                        <ul>
                                            @foreach($question->options as $key => $option)
                                                <li>
                                                    {{ $key }}. {{ $option }}
                                                    @if($key === $question->correct_answer)
                                                        <span class="badge badge-success">Đáp án đúng</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p><strong>Đáp án đúng:</strong> <code>{{ $question->correct_answer }}</code></p>
                                    @endif
                                    
                                    @if($question->explanation)
                                        <p><strong>Giải thích:</strong> {{ $question->explanation }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-question-circle fa-3x mb-3"></i>
                            <br>Chưa có câu hỏi nào
                            <br>
                            <button class="btn btn-primary btn-sm mt-2">
                                <i class="fas fa-plus mr-1"></i>Thêm câu hỏi đầu tiên
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thống kê</h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $quiz->questions->count() }}</h5>
                                <span class="description-text">Câu hỏi</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $quiz->attempts->count() }}</h5>
                                <span class="description-text">Lượt làm</span>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $quiz->questions->sum('points') }}</h5>
                                <span class="description-text">Tổng điểm</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $quiz->attempts->where('is_passed', true)->count() }}</h5>
                                <span class="description-text">Đã đạt</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($quiz->attempts->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lượt làm gần đây</h3>
                </div>
                <div class="card-body">
                    @foreach($quiz->attempts->take(5) as $attempt)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>{{ $attempt->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $attempt->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="text-right">
                                <span class="badge {{ $attempt->is_passed ? 'badge-success' : 'badge-danger' }}">
                                    {{ $attempt->score_percentage }}%
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
