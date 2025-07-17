@extends('layouts.app')

@section('title', $discussion->title)

@section('content')
<div class="container-fluid bg-primary text-white py-5 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Badges -->
                <div class="mb-3">
                    @if($discussion->is_pinned)
                        <span class="badge bg-warning text-dark me-2">
                            <i class="fas fa-thumbtack me-1"></i>Ghim
                        </span>
                    @endif
                    @if($discussion->is_featured)
                        <span class="badge bg-danger me-2">
                            <i class="fas fa-star me-1"></i>Nổi bật
                        </span>
                    @endif
                    @if($discussion->status === 'solved')
                        <span class="badge bg-success me-2">
                            <i class="fas fa-check-circle me-1"></i>Đã giải quyết
                        </span>
                    @elseif($discussion->status === 'closed')
                        <span class="badge bg-secondary me-2">
                            <i class="fas fa-lock me-1"></i>Đã đóng
                        </span>
                    @endif
                </div>
                
                <!-- Title -->
                <h1 class="display-6 fw-bold mb-4">{{ $discussion->title }}</h1>
                
                <!-- Meta Info -->
                <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                    <div class="d-flex align-items-center">
                        <img src="{{ $discussion->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) . '&background=fff&color=007bff' }}" 
                             alt="Avatar" class="rounded-circle me-2" width="40" height="40">
                        <div>
                            <div class="fw-bold">{{ $discussion->user->name }}</div>
                            <small class="opacity-75">{{ $discussion->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
                
                <!-- Category & Course -->
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('discussions.index', ['category' => $discussion->category->id]) }}" 
                       class="btn btn-outline-light btn-sm">
                        @if($discussion->category->icon)
                            <i class="{{ $discussion->category->icon }} me-1"></i>
                        @endif
                        {{ $discussion->category->name }}
                    </a>
                    
                    @if($discussion->course)
                        <a href="{{ route('discussions.index', ['course' => $discussion->course->id]) }}" 
                           class="btn btn-outline-light btn-sm">
                            <i class="fas fa-book me-1"></i>{{ $discussion->course->title }}
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Stats -->
            <div class="col-lg-4">
                <div class="row text-center g-3">
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded p-3">
                            <div class="h4 mb-0">{{ $discussion->votes_count ?? 0 }}</div>
                            <small>Votes</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded p-3">
                            <div class="h4 mb-0">{{ $discussion->replies_count ?? 0 }}</div>
                            <small>Trả lời</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="bg-white bg-opacity-10 rounded p-3">
                            <div class="h4 mb-0">{{ $discussion->views_count ?? 0 }}</div>
                            <small>Lượt xem</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <!-- Main Discussion -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <!-- Vote Buttons -->
                        <div class="col-auto">
                            <div class="d-flex flex-column align-items-center">
                                <button class="btn btn-outline-success btn-sm mb-2" onclick="vote('up', {{ $discussion->id }})">
                                    <i class="fas fa-chevron-up"></i>
                                </button>
                                <div class="fw-bold text-center">{{ $discussion->votes_count ?? 0 }}</div>
                                <button class="btn btn-outline-danger btn-sm mt-2" onclick="vote('down', {{ $discussion->id }})">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="col">
                            <div class="mb-4">
                                {!! $discussion->content !!}
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 flex-wrap">
                                <button class="btn btn-primary btn-sm" onclick="showReplyForm()">
                                    <i class="fas fa-reply me-1"></i>Trả lời
                                </button>
                                
                                @can('update', $discussion)
                                    <a href="{{ route('discussions.edit', $discussion) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit me-1"></i>Sửa
                                    </a>
                                @endcan
                                
                                @can('delete', $discussion)
                                    <form method="POST" action="{{ route('discussions.destroy', $discussion) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Bạn có chắc muốn xóa thảo luận này?')">
                                            <i class="fas fa-trash me-1"></i>Xóa
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Replies -->
            <div id="replies-section">
                @if($discussion->replies && $discussion->replies->count() > 0)
                    @foreach($discussion->replies as $reply)
                        <div id="reply-{{ $reply->id }}" class="card shadow-sm mb-3 {{ $reply->is_best_answer ? 'border-success' : '' }} {{ $reply->is_solution ? 'border-primary' : '' }}">
                            @if($reply->is_best_answer)
                                <div class="card-header bg-success text-white">
                                    <i class="fas fa-check-circle me-1"></i>Câu trả lời tốt nhất
                                </div>
                            @elseif($reply->is_solution)
                                <div class="card-header bg-primary text-white">
                                    <i class="fas fa-lightbulb me-1"></i>Giải pháp
                                </div>
                            @endif
                            
                            <div class="card-body">
                                <div class="row">
                                    <!-- Vote Buttons -->
                                    <div class="col-auto">
                                        <div class="d-flex flex-column align-items-center">
                                            <button class="btn btn-outline-success btn-sm mb-2" onclick="vote('up', {{ $reply->id }}, 'reply')">
                                                <i class="fas fa-chevron-up"></i>
                                            </button>
                                            <div class="fw-bold text-center">{{ $reply->votes_count ?? 0 }}</div>
                                            <button class="btn btn-outline-danger btn-sm mt-2" onclick="vote('down', {{ $reply->id }}, 'reply')">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Reply Content -->
                                    <div class="col">
                                        <!-- User Info -->
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="{{ $reply->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) . '&background=f8f9fa&color=007bff' }}" 
                                                 alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                                            <div>
                                                <div class="fw-bold">{{ $reply->user->name }}</div>
                                                <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        
                                        <!-- Content -->
                                        <div class="mb-3">
                                            {!! $reply->content !!}
                                        </div>
                                        
                                        <!-- Reply Actions -->
                                        <div class="d-flex gap-2 flex-wrap">
                                            <button class="btn btn-outline-primary btn-sm" onclick="replyToReply({{ $reply->id }})">
                                                <i class="fas fa-reply me-1"></i>Trả lời
                                            </button>
                                            
                                            @can('update', $reply)
                                                <button class="btn btn-outline-warning btn-sm">
                                                    <i class="fas fa-edit me-1"></i>Sửa
                                                </button>
                                            @endcan
                                            
                                            @can('delete', $reply)
                                                <form method="POST" action="{{ route('discussion-replies.destroy', $reply) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                            onclick="return confirm('Bạn có chắc muốn xóa câu trả lời này?')">
                                                        <i class="fas fa-trash me-1"></i>Xóa
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Chưa có câu trả lời nào</h5>
                            <p class="text-muted">Hãy là người đầu tiên trả lời thảo luận này!</p>
                            <button class="btn btn-primary" onclick="showReplyForm()">
                                <i class="fas fa-reply me-1"></i>Trả lời ngay
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Reply Form -->
            <div id="reply-form" class="card shadow-sm mt-4" style="display: none;">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-reply me-2"></i>Trả lời thảo luận
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('discussion-replies.store', $discussion) }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Nội dung trả lời</label>
                            <textarea class="form-control" name="content" id="reply-content" rows="6" 
                                      placeholder="Nhập câu trả lời của bạn..." required></textarea>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i>Gửi trả lời
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="hideReplyForm()">
                                <i class="fas fa-times me-1"></i>Hủy
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Discussion Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Thông tin thảo luận
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Tác giả:</small>
                        <div class="fw-bold">{{ $discussion->user->name }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Danh mục:</small>
                        <div class="fw-bold">{{ $discussion->category->name }}</div>
                    </div>
                    
                    @if($discussion->course)
                        <div class="mb-3">
                            <small class="text-muted">Khóa học:</small>
                            <div class="fw-bold">{{ $discussion->course->title }}</div>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <small class="text-muted">Tạo lúc:</small>
                        <div class="fw-bold">{{ $discussion->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    
                    @if($discussion->updated_at != $discussion->created_at)
                        <div class="mb-3">
                            <small class="text-muted">Cập nhật:</small>
                            <div class="fw-bold">{{ $discussion->updated_at->diffForHumans() }}</div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Thao tác nhanh
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm" onclick="showReplyForm()">
                            <i class="fas fa-reply me-1"></i>Trả lời
                        </button>
                        
                        <a href="{{ route('discussions.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Quay lại danh sách
                        </a>
                        
                        <button class="btn btn-outline-info btn-sm" onclick="shareDiscussion()">
                            <i class="fas fa-share me-1"></i>Chia sẻ
                        </button>
                        
                        @auth
                            <button class="btn btn-outline-warning btn-sm" onclick="bookmarkDiscussion()">
                                <i class="fas fa-bookmark me-1"></i>Lưu thảo luận
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Simple JavaScript for Bootstrap 5 only
function vote(type, id, itemType = 'discussion') {
    const url = itemType === 'discussion'
        ? `/api/discussions/${id}/vote`
        : `/api/discussion-replies/${id}/vote`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ type: type })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update vote count - find the vote count element
            const voteElements = document.querySelectorAll('.fw-bold.text-center');
            voteElements.forEach(element => {
                if (element.closest('.d-flex.flex-column.align-items-center')) {
                    const buttons = element.closest('.d-flex.flex-column.align-items-center').querySelectorAll('button');
                    const upButton = Array.from(buttons).find(btn => btn.onclick && btn.onclick.toString().includes(`${id}`));
                    if (upButton) {
                        element.textContent = data.votes_count;
                    }
                }
            });

            // Show success toast
            showToast('Vote đã được cập nhật!', 'success');
        } else {
            showToast(data.message || 'Có lỗi xảy ra', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Có lỗi xảy ra khi vote', 'danger');
    });
}

function showReplyForm() {
    const replyForm = document.getElementById('reply-form');
    replyForm.style.display = 'block';
    replyForm.scrollIntoView({ behavior: 'smooth' });

    // Focus on textarea
    setTimeout(() => {
        document.getElementById('reply-content').focus();
    }, 300);
}

function hideReplyForm() {
    const replyForm = document.getElementById('reply-form');
    replyForm.style.display = 'none';

    // Clear form
    document.getElementById('reply-content').value = '';
}

function replyToReply(replyId) {
    showReplyForm();

    // Add mention to textarea
    const textarea = document.getElementById('reply-content');
    const replyCard = document.querySelector(`[onclick*="${replyId}"]`).closest('.card');
    const replyAuthor = replyCard.querySelector('.fw-bold').textContent;
    textarea.value = `@${replyAuthor} `;
    textarea.focus();

    // Set cursor at end
    textarea.setSelectionRange(textarea.value.length, textarea.value.length);
}

function shareDiscussion() {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            showToast('Link đã được sao chép!', 'info');
        });
    }
}

function bookmarkDiscussion() {
    // Simple bookmark functionality
    showToast('Tính năng bookmark sẽ được phát triển!', 'info');
}

// Simple toast function using Bootstrap 5
function showToast(message, type = 'primary') {
    // Create toast container if not exists
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // Create toast
    const toastId = 'toast-' + Date.now();
    const toastHTML = `
        <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;

    toastContainer.insertAdjacentHTML('beforeend', toastHTML);

    // Show toast
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: 3000
    });
    toast.show();

    // Remove toast element after hidden
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}

// Auto-expand textarea
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('reply-content');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + Enter to submit reply
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            const replyForm = document.getElementById('reply-form');
            if (replyForm.style.display !== 'none') {
                const submitBtn = replyForm.querySelector('button[type="submit"]');
                submitBtn.click();
            }
        }

        // Escape to hide reply form
        if (e.key === 'Escape') {
            hideReplyForm();
        }
    });
});
</script>
@endpush
