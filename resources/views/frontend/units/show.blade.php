@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- صور الوحدة -->
        <div class="col-md-8">
            <div id="uniteCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="status-ribbon {{ $unite->status == 'متاح' ? 'available' : ($unite->status == 'محجوز' ? 'reserved' : 'sold') }}">
                        {{ $unite->status }}
                    </div>
                    @foreach($unite->images as $key => $image)
                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $image->image) }}" 
                             class="d-block w-100 rounded" 
                             alt="{{ $unite->name }}">
                    </div>
                    @endforeach
                </div>
                @if($unite->images->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#uniteCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#uniteCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
                <div class="carousel-counter">
                    <span id="current-slide">1</span>/{{ $unite->images->count() }}
                </div>
                @endif
            </div>
        </div>

        <!-- بيانات الوحدة -->
        <div class="col-md-4">
            <div class="unit-details bg-white rounded p-4">
                <div class="date-location mb-3 text-muted">
                    {{ $unite->created_at->format('j F Y') }} - 
                </div>
                
                <h1 class="h3 mb-3">{{ $unite->name }}</h1>
                
                <div class="location mb-3">
                    <i class="fas fa-map-marker-alt text-primary"></i>
                    <p>{{ $unite->location }}</p>
                </div>
                
                <div class="price mb-4">
                    <h2 class="h4">يبدأ من {{ number_format($unite->price) }} جنيه</h2>
                </div>
                <div class="description">
                    <p>{{ $unite->description }}</p>
                   
                    
                </div>

                <!-- أزرار التواصل -->
                <div class="contact-buttons d-grid gap-2">
                    <a href="https://wa.me/1234567890?text=استفسار عن {{ $unite->name }}" 
                       class="btn btn-success btn-lg" 
                       target="_blank">
                        <i class="fab fa-whatsapp me-2"></i>
                        واتساب
                    </a>
                    
                    <a href="tel:+201234567890" class="btn btn-primary btn-lg">
                        <i class="fas fa-phone me-2"></i>
                        اتصل
                    </a>
                    
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal">
                        حجز الوحدة
                    </button>
                </div>

                <!-- زر المشاركة -->
                <div class="share-button mt-3">
                    <button class="btn btn-outline-secondary w-100" onclick="shareUnit()">
                        <i class="fas fa-share-alt me-2"></i>
                        انشر هذا الكمبوند
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.carousel-item img {
    height: 600px;
    object-fit: cover;
    border-radius: 10px;
}

.carousel-counter {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 14px;
}

.unit-details {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.btn-success {
    background-color: #25D366;
    border-color: #25D366;
}

.btn-success:hover {
    background-color: #128C7E;
    border-color: #128C7E;
}

.btn-light {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
}

.price h2 {
    color: #28a745;
    font-weight: bold;
}

.carousel-control-prev,
.carousel-control-next {
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.9;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: invert(1);
}

.status-ribbon {
    position: absolute;
    top: 20px;
    left: -30px;
    padding: 5px 30px;
    color: white;
    font-weight: bold;
    transform: rotate(-45deg);
    z-index: 2;
    font-size: 14px;
    text-align: center;
    width: 150px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.status-ribbon.available {
    background-color: #28a745;
}

.status-ribbon.reserved {
    background-color: #ffc107;
}

.status-ribbon.sold {
    background-color: #dc3545;
}

.carousel-inner {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
}

@media (min-width: 768px) {
    .status-ribbon {
        top: 40px;
        left: -35px;
        padding: 8px 40px;
        font-size: 16px;
        width: 180px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('bookingForm');
    
    bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // إغلاق Modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('bookingModal'));
                modal.hide();
                
                // عرض رسالة النجاح
                Swal.fire({
                    title: 'تم الحجز بنجاح!',
                    text: 'سيتم التواصل معك قريباً',
                    icon: 'success',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#28a745',
                    timer: 3000,
                    timerProgressBar: true
                });
                
                // إعادة تعيين النموذج
                this.reset();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'خطأ!',
                text: 'حدث خطأ أثناء إرسال الطلب. يرجى المحاولة مرة أخرى.',
                icon: 'error',
                confirmButtonText: 'حسناً',
                confirmButtonColor: '#dc3545'
            });
        });
    });
});
</script>
@endpush

<!-- تأكد من إضافة SweetAlert2 في ملف layout -->
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

<!-- Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">حجز الوحدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="bookingForm" action="{{ route('frontend.bookings.store') }}" method="POST">
                @csrf
                <input type="hidden" name="unite_id" value="{{ $unite->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الاسم</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="tel" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                    <!-- معلومات الوحدة -->
                    <div class="unit-info bg-light p-3 rounded">
                        <h6>تفاصيل الوحدة:</h6>
                        <p class="mb-1">{{ $unite->name }}</p>
                        <p class="mb-1">السعر: {{ number_format($unite->price) }} جنيه</p>
                        <p class="mb-0">الموقع: {{ $unite->location }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">تأكيد الحجز</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection