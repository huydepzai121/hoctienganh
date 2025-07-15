@extends('layouts.app')

@section('title', 'Bảng Xếp Hạng')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="display-4">
                    <i class="fas fa-trophy text-warning me-3"></i>
                    Bảng Xếp Hạng
                </h1>
                
                <div class="d-flex align-items-center">
                    <form method="GET" action="{{ route('leaderboard.index') }}" class="d-flex">
                        <select name="course_id" class="form-select me-2" onchange="this.form.submit()">
                            <option value="">Tất cả khóa học</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ $selectedCourse == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center bg-primary text-white">
                <div class="card-body">
                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                    <h4>{{ number_format($quizStats['total_attempts']) }}</h4>
                    <p class="mb-0">Lượt thi</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-success text-white">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <h4>{{ number_format($quizStats['passed_attempts']) }}</h4>
                    <p class="mb-0">Lượt đạt</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-info text-white">
                <div class="card-body">
                    <i class="fas fa-percentage fa-2x mb-2"></i>
                    <h4>{{ number_format($quizStats['average_score'], 1) }}%</h4>
                    <p class="mb-0">Điểm trung bình</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-warning text-white">
                <div class="card-body">
                    <i class="fas fa-clock fa-2x mb-2"></i>
                    <h4>{{ gmdate('i:s', $quizStats['average_time'] ?? 0) }}</h4>
                    <p class="mb-0">Thời gian TB</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Top Performers -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-crown me-2"></i>
                        Top Học Viên Xuất Sắc
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($topPerformers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Xếp hạng</th>
                                        <th>Học viên</th>
                                        <th>Điểm TB</th>
                                        <th>Lượt thi</th>
                                        <th>Tỷ lệ đạt</th>
                                        <th>Thời gian tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topPerformers as $index => $performer)
                                        <tr class="{{ $index < 3 ? 'table-warning' : '' }}">
                                            <td>
                                                @if($index == 0)
                                                    <i class="fas fa-trophy text-warning fa-lg"></i>
                                                @elseif($index == 1)
                                                    <i class="fas fa-medal text-secondary fa-lg"></i>
                                                @elseif($index == 2)
                                                    <i class="fas fa-award text-danger fa-lg"></i>
                                                @else
                                                    <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($performer->avatar)
                                                        <img src="{{ $performer->avatar }}" class="rounded-circle me-2" width="32" height="32">
                                                    @else
                                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                            <i class="fas fa-user fa-sm"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <a href="{{ route('leaderboard.user', $performer) }}" class="text-decoration-none">
                                                            <strong>{{ $performer->name }}</strong>
                                                        </a>
                                                        <br>
                                                        <small class="text-muted">{{ $performer->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ number_format($performer->average_score, 1) }}%</span>
                                            </td>
                                            <td>{{ $performer->total_attempts }}</td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ number_format(($performer->passed_attempts / $performer->total_attempts) * 100, 1) }}%
                                                </span>
                                            </td>
                                            <td>{{ gmdate('H:i:s', $performer->total_time) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có kết quả nào</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Hoạt động gần đây
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($recentAttempts->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentAttempts as $attempt)
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">
                                            <a href="{{ route('leaderboard.user', $attempt->user) }}" class="text-decoration-none">
                                                {{ $attempt->user->name }}
                                            </a>
                                        </div>
                                        <small class="text-muted">{{ $attempt->quiz->title }}</small>
                                        <br>
                                        <small class="text-muted">{{ $attempt->completed_at->diffForHumans() }}</small>
                                    </div>
                                    <span class="badge bg-{{ $attempt->is_passed ? 'success' : 'danger' }} rounded-pill">
                                        {{ $attempt->score_percentage }}%
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có hoạt động nào</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.table-warning {
    background-color: #fff3cd !important;
}
</style>
@endsection