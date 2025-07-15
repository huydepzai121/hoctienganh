@props(['course'])

<div class="course-reviews mt-5">
    <!-- Reviews Summary -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="display-4 text-warning mb-0">{{ number_format($course->average_rating, 1) }}</h2>
                    <div class="rating mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $course->average_rating ? 'text-warning' : 'text-muted' }}" style="font-size: 1.2rem;"></i>
                        @endfor
                    </div>
                    <p class="text-muted mb-0">{{ $course->review_count }} đánh giá</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Phân bố đánh giá</h6>
                    @foreach($course->rating_distribution as $rating => $data)
                        <div class="d-flex align-items-center mb-2">
                            <span class="me-2" style="width: 60px;">{{ $rating }} sao</span>
                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: {{ $data['percentage'] }}%"></div>
                            </div>
                            <span class="text-muted" style="width: 40px;">{{ $data['count'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Review Form -->
    @auth
        @if($course->students()->where('user_id', auth()->id())->exists())
            @if(!$course->hasUserReviewed(auth()->user()))
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Viết đánh giá của bạn</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('reviews.store', $course) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Đánh giá của bạn</label>
                                <div class="rating-input">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                                        <label for="star{{ $i }}" class="star">
                                            <i class="fas fa-star"></i>
                                        </label>
                                    @endfor
                                </div>
                                @error('rating')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Nhận xét (tùy chọn)</label>
                                <textarea name="comment" id="comment" class="form-control" rows="4" 
                                          placeholder="Chia sẻ trải nghiệm của bạn về khóa học này...">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Gửi đánh giá
                            </button>
                        </form>
                    </div>
                </div>
            @else
                @php $userReview = $course->getUserReview(auth()->user()) @endphp
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Đánh giá của bạn</h5>
                        @if(!$userReview->is_approved)
                            <span class="badge bg-warning">Chờ duyệt</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="rating mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $userReview->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                    <span class="ms-2">{{ $userReview->rating }}/5</span>
                                </div>
                                @if($userReview->comment)
                                    <p class="mb-2">{{ $userReview->comment }}</p>
                                @endif
                                <small class="text-muted">{{ $userReview->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            @if($userReview->canBeEditedBy(auth()->user()))
                                <div class="ms-3">
                                    <button class="btn btn-sm btn-outline-primary" onclick="toggleEditForm()">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                    <form method="POST" action="{{ route('reviews.destroy', $userReview) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa đánh giá này?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <!-- Edit Form (Hidden by default) -->
                        @if($userReview->canBeEditedBy(auth()->user()))
                            <div id="editForm" style="display: none;" class="mt-3 pt-3 border-top">
                                <form method="POST" action="{{ route('reviews.update', $userReview) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Đánh giá</label>
                                        <div class="rating-input">
                                            @for($i = 5; $i >= 1; $i--)
                                                <input type="radio" name="rating" value="{{ $i }}" id="edit_star{{ $i }}" 
                                                       {{ $userReview->rating == $i ? 'checked' : '' }} required>
                                                <label for="edit_star{{ $i }}" class="star">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_comment" class="form-label">Nhận xét</label>
                                        <textarea name="comment" id="edit_comment" class="form-control" rows="4">{{ $userReview->comment }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEditForm()">Hủy</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Bạn cần đăng ký khóa học để có thể đánh giá.
            </div>
        @endif
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <a href="{{ route('login') }}">Đăng nhập</a> để viết đánh giá về khóa học này.
        </div>
    @endauth

    <!-- Reviews List -->
    <div class="reviews-list">
        <h5 class="mb-4">Đánh giá từ học viên ({{ $course->approvedReviews()->count() }})</h5>
        
        @forelse($course->approvedReviews()->with('user')->latest()->take(10)->get() as $review)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex">
                        <img src="{{ $review->user->avatar ?? 'https://via.placeholder.com/50' }}" 
                             alt="Avatar" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">{{ $review->user->name }}</h6>
                                    <div class="rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                        <span class="ms-2 text-muted">{{ $review->rating }}/5</span>
                                    </div>
                                </div>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                            @if($review->comment)
                                <p class="mb-0">{{ $review->comment }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                <p class="text-muted">Chưa có đánh giá nào cho khóa học này.</p>
            </div>
        @endforelse

        @if($course->approvedReviews()->count() > 10)
            <div class="text-center mt-4">
                <button class="btn btn-outline-primary" onclick="loadMoreReviews()">
                    <i class="fas fa-chevron-down me-2"></i>Xem thêm đánh giá
                </button>
            </div>
        @endif
    </div>
</div>

<style>
.rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.rating-input input[type="radio"] {
    display: none;
}

.rating-input .star {
    cursor: pointer;
    font-size: 1.5rem;
    color: #ddd;
    transition: color 0.2s;
}

.rating-input .star:hover,
.rating-input .star:hover ~ .star,
.rating-input input[type="radio"]:checked ~ .star {
    color: #ffc107;
}

.rating .fas.fa-star {
    font-size: 1rem;
}
</style>

<script>
function toggleEditForm() {
    const editForm = document.getElementById('editForm');
    editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';
}

function loadMoreReviews() {
    // Implementation for loading more reviews via AJAX
    console.log('Load more reviews functionality to be implemented');
}
</script>
