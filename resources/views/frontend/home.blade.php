@extends('layouts.frontend')

@section('content')
<div class="hero-section mb-5">
    <div class="hero-overlay"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-md-8 mx-auto text-center text-white">
                <h1 class="display-4 mb-4">ابحث عن منزلك المثالي</h1>
                <p class="lead mb-4">اكتشف أفضل الوحدات السكنية المتاحة في أرقى المناطق</p>
                
                <!-- نموذج البحث -->
                <div class="search-box p-4 bg-white rounded shadow">
                    <form action="{{ route('frontend.search') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="location" class="form-control" placeholder="الموقع">
                            </div>
                            <div class="col-md-6">
                                <select name="price_range" class="form-select">
                                    <option value="">حدد السعر</option>
                                    <option value="1">أقل من مليون</option>
                                    <option value="2">1-2 مليون</option>
                                    <option value="3">أكثر من 2 مليون</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100">بحث</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- أحدث الوحدات -->
<section class="units py-5">
    <div class="container">
        <h2 class="section-title mb-4">الوحدات المتاحة</h2>
        <div class="row">
            @forelse($unites as $unite)
            <div class="col-md-4 mb-4">
                <div class="card unit-card h-100">
                    <div class="position-relative">
                        <div class="status-ribbon {{ $unite->status == 'متاح' ? 'available' : ($unite->status == 'محجوز' ? 'reserved' : 'sold') }}">
                            {{ $unite->status }}
                        </div>
                        @if($unite->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $unite->images->first()->image) }}" 
                             class="card-img-top" alt="{{ $unite->name }}">
                        @else
                        <img src="{{ asset('images/placeholder.jpg') }}" 
                             class="card-img-top" alt="صورة افتراضية">
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $unite->name }}</h5>
                        <p class="card-text text-muted">{{ $unite->location }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">{{ number_format($unite->price) }} جنيه</span>
                            <a href="{{ route('frontend.units.show', $unite) }}" 
                               class="btn btn-outline-primary">التفاصيل</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    لا توجد وحدات متاحة حالياً
                </div>
            </div>
            @endforelse
        </div>

        <!-- ترقيم الصفحات -->
        <div class="d-flex justify-content-center mt-4">
            {{ $unites->links() }}
        </div>
    </div>
</section>

<!-- المميزات -->
<section class="features py-5 bg-light">
    <div class="container">
        <h2 class="section-title mb-4">لماذا تختارنا؟</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-home fa-3x mb-3 text-primary"></i>
                    <h4>أفضل العقارات</h4>
                    <p>نقدم لك مجموعة مختارة من أفضل الوحدات السكنية</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-shield-alt fa-3x mb-3 text-primary"></i>
                    <h4>ضمان الجودة</h4>
                    <p>جميع وحداتنا مضمونة وتخضع لمعايير جودة صارمة</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-headset fa-3x mb-3 text-primary"></i>
                    <h4>دعم متواصل</h4>
                    <p>فريقنا متاح دائماً لمساعدتك في كل خطوة</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.hero-section {
    position: relative;
    padding: 120px 0;
    background: url('/images/frontend/images.jpeg') no-repeat center center;
    background-size: cover;
    min-height: 600px;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
}

.search-box {
    background: rgba(255, 255, 255, 0.95) !important;
}

.unit-card {
    transition: transform 0.3s;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.unit-card:hover {
    transform: translateY(-5px);
}

.unit-card img {
    height: 200px;
    object-fit: cover;
}

.feature-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s;
}

.feature-card:hover {
    transform: translateY(-5px);
}

.price {
    font-size: 1.25rem;
    font-weight: bold;
    color: #28a745;
}

.status-ribbon {
    position: absolute;
    top: 20px;
    left: -30px;
    padding: 5px 30px;
    color: white;
    font-weight: bold;
    transform: rotate(-45deg);
    z-index: 1;
    font-size: 14px;
    text-align: center;
    width: 150px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.status-ribbon.available {
    background-color: #28a745; /* أخضر للوحدات المتاحة */
}

.status-ribbon.reserved {
    background-color: #ffc107; /* أصفر للوحدات المحجوزة */
}

.status-ribbon.sold {
    background-color: #dc3545; /* أحمر للوحدات المباعة */
}

.position-relative {
    overflow: hidden;
}

/* تنسيق ترقيم الصفحات */
.pagination {
    margin: 0;
}

.page-link {
    color: #007bff;
    padding: 0.5rem 1rem;
    margin: 0 3px;
    border-radius: 5px;
}

.page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}

.page-item.disabled .page-link {
    color: #6c757d;
}
</style>
@endpush