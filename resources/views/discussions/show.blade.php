@extends('layouts.app')

@section('title', $discussion->title)

@push('styles')
<style>
.discussion-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
}

.discussion-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

.user-avatar-small {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.vote-buttons {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-right: 1rem;
}

.vote-btn {
    border: none;
    background: none;
    font-size: 1.5rem;
    color: #6c757d;
    transition: all 0.3s ease;
    padding: 0.25rem;
}

.vote-btn:hover {
    color: #007bff;
    transform: scale(1.1);
}

.vote-btn.voted-up {
    color: #28a745;
}

.vote-btn.voted-down {
    color: #dc3545;
}

.vote-count {
    font-weight: bold;
    font-size: 1.2rem;
    margin: 0.5rem 0;
}

.reply-card {
    border-left: 4px solid #e9ecef;
    margin-bottom: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0 10px 10px 0;
}

.reply-card.best-answer {
    border-left-color: #28a745;
    background: #d4edda;
}

.reply-card.solution {
    border-left-color: #007bff;
    background: #d1ecf1;
}

.nested-reply {
    margin-left: 2rem;
    border-left: 2px solid #dee2e6;
    padding-left: 1rem;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
}

.action-btn {
    border: none;
    background: none;
    color: #6c757d;
    font-size: 0.9rem;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: #e9ecef;
    color: #495057;
}

.badge-best-answer {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
    font-size: 0.7rem;
    padding: 0.3rem 0.6rem;
    border-radius: 15px;
    margin-left: 0.5rem;
}

.badge-solution {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    font-size: 0.7rem;
    padding: 0.3rem 0.6rem;
    border-radius: 15px;
    margin-left: 0.5rem;
}

.reply-form {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-top: 2rem;
}

.category-badge {
    font-size: 0.8rem;
    padding: 0.3rem 0.6rem;
    border-radius: 15px;
    text-decoration: none;
    margin-right: 0.5rem;
}

.stats-item {
    text-align: center;
    padding: 0.5rem;
}

.stats-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: white;
}

.stats-label {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.8);
}

.discussion-meta {
    color: rgba(255,255,255,0.9);
    margin-bottom: 1rem;
}

.discussion-content {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    margin-top: -1rem;
    position: relative;
    z-index: 1;
}

.status-badge {
    font-size: 0.8rem;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    margin-left: 1rem;
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
</style>
@endpush

@section('content')
<!-- Discussion Header -->
<div class="discussion-header">
    <div class="container">
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
                    <h1 class="h2 mb-0">{{ $discussion->title }}</h1>
                    @if($discussion->status === 'solved')
                        <span class="status-badge bg-success text-white">
                            <i class="fas fa-check mr-1"></i>Đã giải quyết
                        </span>
                    @elseif($discussion->status === 'closed')
                        <span class="status-badge bg-secondary text-white">
                            <i class="fas fa-lock mr-1"></i>Đã đóng
                        </span>
                    @endif
                </div>
                
                <div class="discussion-meta">
                    <img src="{{ $discussion->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) . '&background=fff&color=667eea' }}" 
                         alt="Avatar" class="user-avatar mr-2">
                    <strong>{{ $discussion->user->name }}</strong>
                    <span class="mx-2">•</span>
                    <span>{{ $discussion->created_at->diffForHumans() }}</span>
                    @if($discussion->last_activity_at && $discussion->last_activity_at != $discussion->created_at)
                        <span class="mx-2">•</span>
                        <span>Hoạt động cuối: {{ $discussion->last_activity_at->diffForHumans() }}</span>
                    @endif
                </div>

                <div class="mt-3">
                    <a href="{{ route('discussions.index', ['category' => $discussion->category->id]) }}" 
                       class="category-badge text-white"
                       style="background-color: {{ $discussion->category->color }}">
                        @if($discussion->category->icon)
                            <i class="{{ $discussion->category->icon }} mr-1"></i>
                        @endif
                        {{ $discussion->category->name }}
                    </a>
                    
                    @if($discussion->course)
                        <a href="{{ route('discussions.index', ['course' => $discussion->course->id]) }}" 
                           class="category-badge bg-info text-white">
                            <i class="fas fa-book mr-1"></i>{{ $discussion->course->title }}
                        </a>
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

<div class="container">
    <!-- Discussion Content -->
    <div class="discussion-content">
        <div class="row">
            <div class="col-md-1">
                @auth
                    <div class="vote-buttons">
                        <button class="vote-btn vote-up {{ $discussion->getUserVoteType(auth()->id()) === 'up' ? 'voted-up' : '' }}" 
                                data-type="up" data-id="{{ $discussion->id }}" data-model="discussion">
                            <i class="fas fa-chevron-up"></i>
                        </button>
                        <div class="vote-count">{{ $discussion->getVoteScore() }}</div>
                        <button class="vote-btn vote-down {{ $discussion->getUserVoteType(auth()->id()) === 'down' ? 'voted-down' : '' }}" 
                                data-type="down" data-id="{{ $discussion->id }}" data-model="discussion">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                @else
                    <div class="vote-buttons">
                        <div class="vote-btn">
                            <i class="fas fa-chevron-up"></i>
                        </div>
                        <div class="vote-count">{{ $discussion->getVoteScore() }}</div>
                        <div class="vote-btn">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                @endauth
            </div>
            <div class="col-md-11">
                <div class="discussion-text">
                    {!! nl2br(e($discussion->content)) !!}
                </div>
                
                @auth
                    @if(auth()->id() === $discussion->user_id || auth()->user()->isAdmin())
                        <div class="action-buttons">
                            <a href="{{ route('discussions.edit', $discussion->slug) }}" class="action-btn">
                                <i class="fas fa-edit mr-1"></i>Chỉnh sửa
                            </a>
                            @if(auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('discussions.destroy', $discussion->slug) }}" 
                                      style="display: inline;" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa thảo luận này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn text-danger">
                                        <i class="fas fa-trash mr-1"></i>Xóa
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- Replies -->
    <div class="replies-section">
        <h4 class="mb-3">
            <i class="fas fa-comments mr-2"></i>
            Trả lời ({{ $discussion->replies_count }})
        </h4>
        
        @forelse($discussion->replies as $reply)
            <div class="reply-card {{ $reply->is_best_answer ? 'best-answer' : '' }} {{ $reply->is_solution ? 'solution' : '' }}" 
                 id="reply-{{ $reply->id }}">
                <div class="row">
                    <div class="col-md-1">
                        @auth
                            <div class="vote-buttons">
                                <button class="vote-btn vote-up {{ $reply->getUserVoteType(auth()->id()) === 'up' ? 'voted-up' : '' }}" 
                                        data-type="up" data-id="{{ $reply->id }}" data-model="reply">
                                    <i class="fas fa-chevron-up"></i>
                                </button>
                                <div class="vote-count">{{ $reply->getVoteScore() }}</div>
                                <button class="vote-btn vote-down {{ $reply->getUserVoteType(auth()->id()) === 'down' ? 'voted-down' : '' }}" 
                                        data-type="down" data-id="{{ $reply->id }}" data-model="reply">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                        @else
                            <div class="vote-buttons">
                                <div class="vote-btn">
                                    <i class="fas fa-chevron-up"></i>
                                </div>
                                <div class="vote-count">{{ $reply->getVoteScore() }}</div>
                                <div class="vote-btn">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        @endauth
                    </div>
                    <div class="col-md-11">
                        <div class="d-flex align-items-center mb-2">
                            <img src="{{ $reply->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) . '&background=007bff&color=fff' }}" 
                                 alt="Avatar" class="user-avatar-small mr-2">
                            <strong>{{ $reply->user->name }}</strong>
                            <span class="text-muted mx-2">•</span>
                            <span class="text-muted">{{ $reply->created_at->diffForHumans() }}</span>
                            
                            @if($reply->is_best_answer)
                                <span class="badge-best-answer">
                                    <i class="fas fa-star mr-1"></i>Câu trả lời hay nhất
                                </span>
                            @endif
                            
                            @if($reply->is_solution)
                                <span class="badge-solution">
                                    <i class="fas fa-check mr-1"></i>Giải pháp
                                </span>
                            @endif
                        </div>
                        
                        <div class="reply-content">
                            {!! nl2br(e($reply->content)) !!}
                        </div>
                        
                        @auth
                            <div class="action-buttons">
                                <button class="action-btn reply-to-btn" data-reply-id="{{ $reply->id }}">
                                    <i class="fas fa-reply mr-1"></i>Trả lời
                                </button>
                                
                                @if(auth()->id() === $discussion->user_id && !$reply->is_best_answer)
                                    <form method="POST" action="{{ route('discussion-replies.best-answer', $reply) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn text-success">
                                            <i class="fas fa-star mr-1"></i>Đánh dấu hay nhất
                                        </button>
                                    </form>
                                @endif
                                
                                @if((auth()->id() === $discussion->user_id || auth()->user()->isAdmin()) && !$reply->is_solution)
                                    <form method="POST" action="{{ route('discussion-replies.solution', $reply) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn text-primary">
                                            <i class="fas fa-check mr-1"></i>Đánh dấu giải pháp
                                        </button>
                                    </form>
                                @endif
                                
                                @if(auth()->id() === $reply->user_id || auth()->user()->isAdmin())
                                    <form method="POST" action="{{ route('discussion-replies.destroy', $reply) }}" 
                                          style="display: inline;" 
                                          onsubmit="return confirm('Bạn có chắc muốn xóa câu trả lời này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn text-danger">
                                            <i class="fas fa-trash mr-1"></i>Xóa
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endauth
                        
                        <!-- Nested Replies -->
                        @if($reply->children->count() > 0)
                            <div class="nested-replies mt-3">
                                @foreach($reply->children as $childReply)
                                    <div class="nested-reply">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ $childReply->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($childReply->user->name) . '&background=28a745&color=fff' }}" 
                                                 alt="Avatar" class="user-avatar-small mr-2">
                                            <strong>{{ $childReply->user->name }}</strong>
                                            <span class="text-muted mx-2">•</span>
                                            <span class="text-muted">{{ $childReply->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="reply-content">
                                            {!! nl2br(e($childReply->content)) !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Chưa có câu trả lời nào</h5>
                <p class="text-muted">Hãy là người đầu tiên trả lời thảo luận này!</p>
            </div>
        @endforelse
    </div>

    <!-- Reply Form -->
    @auth
        @if($discussion->status === 'open')
            <div class="reply-form">
                <h5 class="mb-3">
                    <i class="fas fa-reply mr-2"></i>Trả lời thảo luận
                </h5>
                <form method="POST" action="{{ route('discussion-replies.store', $discussion) }}" id="reply-form">
                    @csrf
                    <input type="hidden" name="parent_id" id="parent_id">
                    <div class="form-group">
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  name="content" 
                                  rows="4" 
                                  placeholder="Nhập câu trả lời của bạn..."
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-secondary mr-2" id="cancel-reply" style="display: none;">
                            Hủy
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane mr-2"></i>Gửi trả lời
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="alert alert-warning text-center">
                <i class="fas fa-lock mr-2"></i>
                Thảo luận này đã được đóng, không thể trả lời thêm.
            </div>
        @endif
    @else
        <div class="reply-form text-center">
            <h5 class="mb-3">Bạn cần đăng nhập để trả lời</h5>
            <a href="{{ route('login') }}" class="btn btn-primary">
                <i class="fas fa-sign-in-alt mr-2"></i>Đăng nhập
            </a>
        </div>
    @endauth
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Vote functionality
    $('.vote-btn').click(function() {
        const type = $(this).data('type');
        const id = $(this).data('id');
        const model = $(this).data('model');
        const button = $(this);
        
        let url;
        if (model === 'discussion') {
            url = `/discussions/${id}/vote`;
        } else {
            url = `/discussion-replies/${id}/vote`;
        }
        
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                type: type
            },
            success: function(response) {
                // Update vote count
                button.siblings('.vote-count').text(response.votes_count);
                
                // Update button states
                const voteButtons = button.parent();
                voteButtons.find('.vote-btn').removeClass('voted-up voted-down');
                
                if (response.user_vote === 'up') {
                    voteButtons.find('.vote-up').addClass('voted-up');
                } else if (response.user_vote === 'down') {
                    voteButtons.find('.vote-down').addClass('voted-down');
                }
                
                // Show success message
                if (response.message) {
                    // You can add a toast notification here
                    console.log(response.message);
                }
            },
            error: function() {
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            }
        });
    });
    
    // Reply to specific comment
    $('.reply-to-btn').click(function() {
        const replyId = $(this).data('reply-id');
        $('#parent_id').val(replyId);
        $('#cancel-reply').show();
        $('textarea[name="content"]').attr('placeholder', 'Trả lời câu hỏi này...');
        $('textarea[name="content"]').focus();
    });
    
    // Cancel reply
    $('#cancel-reply').click(function() {
        $('#parent_id').val('');
        $(this).hide();
        $('textarea[name="content"]').attr('placeholder', 'Nhập câu trả lời của bạn...');
    });
});
</script>
@endpush
@endsection
