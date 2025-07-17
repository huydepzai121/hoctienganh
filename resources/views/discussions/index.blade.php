@extends('layouts.app')

@section('title', 'Thảo luận')

@section('content')
<!-- Hero Section -->
<div class="bg-primary text-white py-5 mb-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-comments me-3"></i>Thảo luận
                </h1>
                <p class="lead mb-4">Tham gia thảo luận và đặt câu hỏi với cộng đồng học tiếng Anh</p>
                
                @auth
                    <a href="{{ route('discussions.create') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-plus me-2"></i>Tạo thảo luận mới
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập để tham gia
                    </a>
                @endauth
            </div>
            
            <div class="col-lg-4 text-center">
                <div class="row g-3">
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded p-3">
                            <div class="h4 mb-0">{{ $totalDiscussions ?? 0 }}</div>
                            <small>Thảo luận</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded p-3">
                            <div class="h4 mb-0">{{ $totalReplies ?? 0 }}</div>
                            <small>Trả lời</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded p-3">
                            <div class="h4 mb-0">{{ $activeUsers ?? 0 }}</div>
                            <small>Thành viên</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-filter me-2"></i>Bộ lọc
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Search -->
                    <form method="GET" action="{{ route('discussions.index') }}">
                        <div class="mb-3">
                            <label class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" placeholder="Tìm thảo luận...">
                        </div>
                        
                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label class="form-label">Danh mục</label>
                            <select class="form-select" name="category">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Course Filter -->
                        <div class="mb-3">
                            <label class="form-label">Khóa học</label>
                            <select class="form-select" name="course">
                                <option value="">Tất cả khóa học</option>
                                @foreach($courses ?? [] as $course)
                                    <option value="{{ $course->id }}" 
                                            {{ request('course') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Status Filter -->
                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select" name="status">
                                <option value="">Tất cả</option>
                                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Mở</option>
                                <option value="solved" {{ request('status') == 'solved' ? 'selected' : '' }}>Đã giải quyết</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Đã đóng</option>
                            </select>
                        </div>
                        
                        <!-- Sort -->
                        <div class="mb-3">
                            <label class="form-label">Sắp xếp</label>
                            <select class="form-select" name="sort">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                                <option value="most_replies" {{ request('sort') == 'most_replies' ? 'selected' : '' }}>Nhiều trả lời</option>
                                <option value="most_votes" {{ request('sort') == 'most_votes' ? 'selected' : '' }}>Nhiều vote</option>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>Lọc
                            </button>
                            <a href="{{ route('discussions.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Xóa bộ lọc
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Quick Categories -->
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-tags me-2"></i>Danh mục phổ biến
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @foreach($popularCategories ?? [] as $category)
                            <a href="{{ route('discussions.index', ['category' => $category->id]) }}" 
                               class="btn btn-outline-primary btn-sm text-start">
                                @if($category->icon)
                                    <i class="{{ $category->icon }} me-2"></i>
                                @endif
                                {{ $category->name }}
                                <span class="badge bg-primary ms-auto">{{ $category->discussions_count ?? 0 }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Action Bar -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0">
                        @if(request('search'))
                            Kết quả tìm kiếm: "{{ request('search') }}"
                        @elseif(request('category'))
                            Danh mục: {{ $categories->find(request('category'))->name ?? 'Không xác định' }}
                        @else
                            Tất cả thảo luận
                        @endif
                    </h5>
                    <small class="text-muted">{{ $discussions->total() ?? 0 }} thảo luận</small>
                </div>
                
                @auth
                    <a href="{{ route('discussions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Tạo mới
                    </a>
                @endauth
            </div>
            
            <!-- Discussions List -->
            @if($discussions && $discussions->count() > 0)
                @foreach($discussions as $discussion)
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="row">
                                <!-- Vote & Stats -->
                                <div class="col-auto">
                                    <div class="text-center">
                                        <div class="fw-bold text-success">{{ $discussion->votes_count ?? 0 }}</div>
                                        <small class="text-muted">votes</small>
                                    </div>
                                    <div class="text-center mt-2">
                                        <div class="fw-bold text-primary">{{ $discussion->replies_count ?? 0 }}</div>
                                        <small class="text-muted">trả lời</small>
                                    </div>
                                    <div class="text-center mt-2">
                                        <div class="fw-bold text-info">{{ $discussion->views_count ?? 0 }}</div>
                                        <small class="text-muted">lượt xem</small>
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="col">
                                    <!-- Title & Badges -->
                                    <div class="mb-2">
                                        @if($discussion->is_pinned)
                                            <span class="badge bg-warning text-dark me-1">
                                                <i class="fas fa-thumbtack me-1"></i>Ghim
                                            </span>
                                        @endif
                                        @if($discussion->is_featured)
                                            <span class="badge bg-danger me-1">
                                                <i class="fas fa-star me-1"></i>Nổi bật
                                            </span>
                                        @endif
                                        @if($discussion->status === 'solved')
                                            <span class="badge bg-success me-1">
                                                <i class="fas fa-check-circle me-1"></i>Đã giải quyết
                                            </span>
                                        @elseif($discussion->status === 'closed')
                                            <span class="badge bg-secondary me-1">
                                                <i class="fas fa-lock me-1"></i>Đã đóng
                                            </span>
                                        @endif
                                        
                                        <a href="{{ route('discussions.show', $discussion->slug) }}" 
                                           class="text-decoration-none">
                                            <h6 class="mb-0 text-dark">{{ $discussion->title }}</h6>
                                        </a>
                                    </div>
                                    
                                    <!-- Excerpt -->
                                    <p class="text-muted mb-2">
                                        {{ Str::limit(strip_tags($discussion->content), 150) }}
                                    </p>
                                    
                                    <!-- Meta Info -->
                                    <div class="d-flex flex-wrap align-items-center gap-3">
                                        <!-- Author -->
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $discussion->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) . '&background=f8f9fa&color=007bff' }}" 
                                                 alt="Avatar" class="rounded-circle me-2" width="24" height="24">
                                            <small class="text-muted">{{ $discussion->user->name }}</small>
                                        </div>
                                        
                                        <!-- Category -->
                                        <a href="{{ route('discussions.index', ['category' => $discussion->category->id]) }}" 
                                           class="badge bg-primary text-decoration-none">
                                            @if($discussion->category->icon)
                                                <i class="{{ $discussion->category->icon }} me-1"></i>
                                            @endif
                                            {{ $discussion->category->name }}
                                        </a>
                                        
                                        <!-- Course -->
                                        @if($discussion->course)
                                            <a href="{{ route('discussions.index', ['course' => $discussion->course->id]) }}" 
                                               class="badge bg-info text-decoration-none">
                                                <i class="fas fa-book me-1"></i>{{ $discussion->course->title }}
                                            </a>
                                        @endif
                                        
                                        <!-- Time -->
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>{{ $discussion->created_at->diffForHumans() }}
                                        </small>
                                        
                                        <!-- Last Activity -->
                                        @if($discussion->last_activity_at && $discussion->last_activity_at != $discussion->created_at)
                                            <small class="text-muted">
                                                <i class="fas fa-comment me-1"></i>{{ $discussion->last_activity_at->diffForHumans() }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $discussions->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-comments fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted mb-3">Chưa có thảo luận nào</h4>
                        <p class="text-muted mb-4">
                            @if(request()->hasAny(['search', 'category', 'course', 'status']))
                                Không tìm thấy thảo luận nào phù hợp với bộ lọc của bạn.
                            @else
                                Hãy là người đầu tiên tạo thảo luận!
                            @endif
                        </p>
                        
                        <div class="d-flex gap-2 justify-content-center">
                            @auth
                                <a href="{{ route('discussions.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Tạo thảo luận đầu tiên
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập để tạo thảo luận
                                </a>
                            @endauth
                            
                            @if(request()->hasAny(['search', 'category', 'course', 'status']))
                                <a href="{{ route('discussions.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Xóa bộ lọc
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
