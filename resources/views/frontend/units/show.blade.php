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
                    
                    <a href="" class="btn btn-light btn-lg">
                      حجز الوحدة
                    
                    </a>
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
function shareUnit() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $unite->name }}',
            text: '{{ $unite->description }}',
            url: window.location.href
        });
    }
}
</script>
@endpush
@endsection