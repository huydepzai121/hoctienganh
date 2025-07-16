@extends('layouts.app')

@section('title', 'Thảo luận')

@push('styles')
<style>
.discussion-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1rem;
}

.discussion-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.category-badge {
    font-size: 0.8rem;
    padding: 0.3rem 0.6rem;
    border-radius: 15px;
    text-decoration: none;
}

.stats-item {
    text-align: center;
    padding: 0.5rem;
}

.stats-number {
    font-size: 1.2rem;
    font-weight: bold;
    color: #495057;
}

.stats-label {
    font-size: 0.8rem;
    color: #6c757d;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.discussion-meta {
    font-size: 0.9rem;
    color: #6c757d;
}

.pinned-badge {
    background: linear-gradient(45deg, #ffc107, #ff8f00);
    color: white;
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
    margin-right: 0.5rem;
}

.featured-badge {
    background: linear-gradient(45deg, #dc3545, #c82333);
    color: white;
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
    margin-right: 0.5rem;
}

.filter-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.create-btn {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
    border-radius: 25px;
    padding: 0.75rem 2rem;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
}

.create-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,123,255,0.3);
    color: white;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}
</style>
@endpush

@section('content')
<div class="container">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 font-weight-bold">
                <i class="fas fa-comments text-primary mr-2"></i>
                Thảo luận
            </h1>
            <p class="text-muted">Tham gia thảo luận và đặt câu hỏi với cộng đồng học tiếng Anh</p>
        </div>
        <div class="col-md-4 text-right">
            @auth
                <a href="{{ route('discussions.create') }}" class="btn create-btn">
                    <i class="fas fa-plus mr-2"></i>Tạo thảo luận mới
                </a>
            @else
                <a href="{{ route('login') }}" class="btn create-btn">
                    <i class="fas fa-sign-in-alt mr-2"></i>Đăng nhập để thảo luận
                </a>
            @endauth
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-card">
        <form method="GET" action="{{ route('discussions.index') }}" class="row align-items-end">
            <div class="col-md-3">
                <label class="form-label font-weight-bold">
                    <i class="fas fa-folder mr-1"></i>Danh mục
                </label>
                <select name="category" class="form-control">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label font-weight-bold">
                    <i class="fas fa-book mr-1"></i>Khóa học
                </label>
                <select name="course" class="form-control">
                    <option value="">Tất cả khóa học</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label font-weight-bold">
                    <i class="fas fa-filter mr-1"></i>Trạng thái
                </label>
                <select name="status" class="form-control">
                    <option value="">Tất cả</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Đang mở</option>
                    <option value="solved" {{ request('status') === 'solved' ? 'selected' : '' }}>Đã giải quyết</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Đã đóng</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label font-weight-bold">
                    <i class="fas fa-sort mr-1"></i>Sắp xếp
                </label>
                <select name="sort" class="form-control">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Phổ biến</option>
                    <option value="most_replies" {{ request('sort') === 'most_replies' ? 'selected' : '' }}>Nhiều trả lời</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-search mr-2"></i>Lọc
                </button>
            </div>
        </form>
    </div>

    <!-- Search -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" action="{{ route('discussions.index') }}" class="input-group">
                <input type="text" name="search" class="form-control form-control-lg" 
                       placeholder="Tìm kiếm thảo luận..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="text-muted">
                Tìm thấy {{ number_format($discussions->total()) }} thảo luận
            </div>
        </div>
    </div>

    <!-- Categories Quick Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-wrap">
                <a href="{{ route('discussions.index') }}" 
                   class="category-badge {{ !request('category') ? 'bg-primary text-white' : 'bg-light text-dark' }} mr-2 mb-2">
                    <i class="fas fa-th mr-1"></i>Tất cả
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('discussions.index', ['category' => $category->id]) }}" 
                       class="category-badge {{ request('category') == $category->id ? 'text-white' : 'text-dark' }} mr-2 mb-2"
                       style="background-color: {{ request('category') == $category->id ? $category->color : '#f8f9fa' }}">
                        @if($category->icon)
                            <i class="{{ $category->icon }} mr-1"></i>
                        @endif
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Discussions List -->
    <div class="row">
        <div class="col-12">
            @forelse($discussions as $discussion)
                <div class="discussion-card card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex align-items-start mb-2">
                                    @if($discussion->is_pinned)
                                        <span class="pinned-badge">
                                            <i class="fas fa-thumbtack mr-1"></i>Ghim
                                        </span>
                                    @endif
                                    @if($discussion->is_featured)
                                        <span class="featured-badge">
                                            <i class="fas fa-star mr-1"></i>Nổi bật
                                        </span>
                                    @endif
                                    <h5 class="mb-0">
                                        <a href="{{ route('discussions.show', $discussion->slug) }}" 
                                           class="text-dark text-decoration-none">
                                            {{ $discussion->title }}
                                        </a>
                                    </h5>
                                </div>
                                
                                <div class="mb-2">
                                    <a href="{{ route('discussions.index', ['category' => $discussion->category->id]) }}" 
                                       class="category-badge text-white text-decoration-none"
                                       style="background-color: {{ $discussion->category->color }}">
                                        @if($discussion->category->icon)
                                            <i class="{{ $discussion->category->icon }} mr-1"></i>
                                        @endif
                                        {{ $discussion->category->name }}
                                    </a>
                                    
                                    @if($discussion->course)
                                        <a href="{{ route('discussions.index', ['course' => $discussion->course->id]) }}" 
                                           class="category-badge bg-info text-white text-decoration-none ml-2">
                                            <i class="fas fa-book mr-1"></i>{{ $discussion->course->title }}
                                        </a>
                                    @endif
                                    
                                    @if($discussion->status === 'solved')
                                        <span class="category-badge bg-success text-white ml-2">
                                            <i class="fas fa-check mr-1"></i>Đã giải quyết
                                        </span>
                                    @elseif($discussion->status === 'closed')
                                        <span class="category-badge bg-secondary text-white ml-2">
                                            <i class="fas fa-lock mr-1"></i>Đã đóng
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="discussion-meta">
                                    <img src="{{ $discussion->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) . '&background=007bff&color=fff' }}" 
                                         alt="Avatar" class="user-avatar mr-2">
                                    <strong>{{ $discussion->user->name }}</strong>
                                    <span class="mx-2">•</span>
                                    <span>{{ $discussion->created_at->diffForHumans() }}</span>
                                    @if($discussion->last_activity_at && $discussion->last_activity_at != $discussion->created_at)
                                        <span class="mx-2">•</span>
                                        <span>Hoạt động cuối: {{ $discussion->last_activity_at->diffForHumans() }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="stats-item">
                                            <div class="stats-number">{{ $discussion->votes_count }}</div>
                                            <div class="stats-label">Votes</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stats-item">
                                            <div class="stats-number">{{ $discussion->replies_count }}</div>
                                            <div class="stats-label">Trả lời</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stats-item">
                                            <div class="stats-number">{{ number_format($discussion->views_count) }}</div>
                                            <div class="stats-label">Lượt xem</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-comments"></i>
                    <h5>Chưa có thảo luận nào</h5>
                    <p>Hãy là người đầu tiên tạo thảo luận trong cộng đồng!</p>
                    @auth
                        <a href="{{ route('discussions.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i>Tạo thảo luận đầu tiên
                        </a>
                    @endauth
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($discussions->hasPages())
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $discussions->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
