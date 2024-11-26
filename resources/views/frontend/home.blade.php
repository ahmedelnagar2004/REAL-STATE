@extends('layouts.frontend')

@section('content')
<div class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="search-wrapper">
            <div class="hero-content text-center mb-4">
                <h1 class="main-title mb-3">ابحث عن منزلك المثالي</h1>
                <p class="sub-title">اكتشف أفضل الوحدات السكنية المتاحة في أرقى المناطق</p>
            </div>

            <div class="search-container">
                <form action="{{ route('frontend.search') }}" method="GET" class="search-form">
                    <div class="row g-3">
                        <div class="col-lg-5">
                            <div class="search-input-group">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" 
                                       name="location" 
                                       class="form-control" 
                                       placeholder="ابحث عن موقع..."
                                       autocomplete="off">
                            </div>
                        </div>
                        
                        <div class="col-lg-5">
                            <div class="search-input-group">
                                <i class="fas fa-money-bill-wave"></i>
                                <select name="price_range" class="form-select">
                                    <option value="">حدد السعر</option>
                                    <option value="1">أقل من مليون جنيه</option>
                                    <option value="2">1-2 مليون جنيه</option>
                                    <option value="3">2-3 مليون جنيه</option>
                                    <option value="4">أكثر من 3 مليون جنيه</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-primary search-btn w-100">
                                <i class="fas fa-search"></i>
                                بحث
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- أحدث الوحدات -->
<section class="units py-5">
    <div class="container">
        <h2 class="section-title mb-4" style="text-align: center;
        color:white;
        ">الوحدات المتاحة</h2>
        <div class="row">
            @forelse($unites as $unite)
            <div class="col-md-4 mb-4">
                <div class="property-card">
                    <!-- شريط الحالة -->
                    <div class="status-badge status-{{ $unite->status }}">
                        {{ $unite->status }}
                    </div>
                    
                    <!-- صورة العقار -->
                    <div class="property-image">
                        @if($unite->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $unite->images->first()->image) }}" alt="{{ $unite->name }}">
                        @else
                            <img src="{{ asset('images/placeholder.jpg') }}" alt="صورة افتراضية">
                        @endif
                    </div>
                    
                    <!-- محتوى الكارت -->
                    <div class="property-content">
                        <h3 class="property-title">{{ $unite->name }}</h3>
                        <p class="property-location">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $unite->location }}
                        </p>
                        <div class="property-price">
                            <span class="amount">{{ number_format($unite->price) }}</span>
                            <span class="currency">جنيه</span>
                        </div>
                        
                        <a href="{{ route('frontend.units.show', $unite) }}" class="details-btn">
                            <span>التفاصيل</span>
                            <i class="fas fa-arrow-left"></i>
                        </a>
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
        <h2 class="section-title mb-4" style="text-align: center;
        color:black;
        ">لماذا تختارنا؟</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-home fa-3x mb-3 text-primary"></i>
                    <h4 style=" color:black;">أفضل العقارات</h4>
                    <p  style=" color:black;">نقدم لك مجموعة مختارة من أفضل الوحدات السكنية</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-shield-alt fa-3x mb-3 text-primary"></i>
                    <h4 style=" color:black;">ضمان الجودة</h4>
                    <p style=" color:black;">جميع وحداتنا مضمونة وتخضع لمعايير جودة صارمة</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-headset fa-3x mb-3 text-primary"></i>
                    <h4 style=" color:black;">دعم متواصل</h4>
                    <p style=" color:black;">فريقنا متاح دائماً لمساعدتك في كل خطوة</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- إضافة سيكشن الإحصائيات -->
<section class="statistics py-5" style="background-color: #0a2640;">
    <div class="container position-relative">
        <h2 class="text-center text-white mb-5">Valuated</h2>
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <h3 class="counter text-white display-4" data-target="10000">0</h3>
                    <p class="text-white-50">Real Estate Evaluations</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <h3 class="counter text-white display-4" data-target="99">0</h3>
                    <p class="text-white-50">Residential property</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <h3 class="counter text-white display-4" data-target="1000000">0</h3>
                    <p class="text-white-50">Commercial property</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <h3 class="counter text-white display-4" data-target="99">0</h3>
                    <p class="text-white-50">Agricultural Property</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- الرسومات المتحركة -->
    <div class="city-line">
        <!-- المجموعة الأولى من المباني -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="city-svg">
            <!-- مباني كلاسيكية مع نوافذ -->
            <path class="building" d="M0,160 L40,160 L40,80 L60,60 L80,80 L80,160"/>
            <path class="building" d="M100,160 L140,160 L140,40 L160,20 L180,40 L180,160"/>
            
            <!-- برج حديث مع قمة مميزة -->
            <path class="building" d="M200,160 L240,160 L240,30 L260,10 L280,30 L280,160"/>
            
            <!-- مجمع مباني متدرجة -->
            <path class="building" d="M300,160 L340,160 L340,120 L360,100 L380,80 L400,60 L420,40 L440,60 L440,160"/>
            
            <!-- مسجد مع قبة ومئذنة -->
            <path class="building" d="M460,160 L500,160 L500,80 C500,60 520,40 540,40 C560,40 580,60 580,80 L580,160"/>
            <path class="building" d="M520,40 L520,10"/> <!-- مئذنة -->
            
            <!-- ناطحة سحاب مع تصميم زجزاج -->
            <path class="building" d="M600,160 L640,160 L640,20 L660,10 L680,20 L680,40 L660,50 L680,60 L680,160"/>
            
            <!-- مبنى مع شرفات -->
            <path class="building" d="M700,160 L740,160 L740,120 L760,120 L760,80 L780,80 L780,40 L800,40 L800,160"/>
            
            <!-- مباني سكنية متنوعة -->
            <path class="building" d="M820,160 L860,160 L860,100 L880,80 L900,100 L900,160"/>
            <path class="building" d="M920,160 L960,160 L960,70 L980,50 L1000,70 L1000,160"/>
            
            <!-- برج مستقبلي -->
            <path class="building" d="M1020,160 L1060,160 L1060,20 L1080,5 L1100,20 L1100,160"/>
            
            <!-- مجمع تجاري -->
            <path class="building" d="M1120,160 L1160,160 L1160,80 L1180,60 L1200,80 L1200,120 L1220,100 L1240,120 L1240,160"/>
            
            <!-- تفاصيل إضافية -->
            <circle cx="520" cy="60" r="15" class="building-detail"/> <!-- قبة المسجد -->
            <rect x="840" y="120" width="10" height="10" class="building-detail"/> <!-- نوافذ -->
            <rect x="940" y="90" width="10" height="10" class="building-detail"/>
        </svg>
    </div>
</section>
@endsection

@push('styles')
<style>
.hero-section {
    position: relative;
    min-height: 500px;
    display: flex;
    align-items: center;
    padding: 100px 0;
    background-image: url('images/frontend/images.jpeg');
    background-size: cover;
    background-position: center;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
}

.search-wrapper {
    position: relative;
    z-index: 2;
    max-width: 1000px;
    margin: 0 auto;
}

.main-title {
    color: #ffffff;
    font-size: 3rem;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    margin-bottom: 1rem;
}

.sub-title {
    color: #ffffff;
    font-size: 1.25rem;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    margin-bottom: 2rem;
}

.search-container {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.search-input-group {
    position: relative;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.search-input-group:hover {
    background: rgba(255, 255, 255, 0.2);
}

.search-input-group i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #000000;
    font-size: 1.2rem;
    z-index: 1;
    opacity: 0.7;
}

.search-input-group .form-control,
.search-input-group .form-select {
    height: 55px;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    padding-left: 45px;
    color: #000000;
    font-size: 1rem;
}

.search-input-group .form-control::placeholder {
    color: rgba(0, 0, 0, 0.6);
}

.search-input-group .form-select option {
    color: #000000;
    background: #ffffff;
}

.search-btn {
    height: 55px;
    font-size: 1.1rem;
    font-weight: 500;
    background: #1a73e8;
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.search-btn:hover {
    background: #1557b0;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26, 115, 232, 0.3);
}

/* تحسين التجاوب */
@media (max-width: 991px) {
    .main-title {
        font-size: 2rem;
    }
    
    .sub-title {
        font-size: 1.1rem;
    }
    
    .search-container {
        padding: 20px;
    }
}

.property-card {
    background: #ffffff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    position: relative;
    margin-bottom: 20px;
}

.property-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.status-badge {
    position: absolute;
    top: 20px;
    left: -30px;
    color: white;
    padding: 5px 30px;
    transform: rotate(-45deg);
    z-index: 1;
    font-size: 14px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    font-weight: 600;
    text-align: center;
    min-width: 120px;
}

.status-متاح {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    border: 1px solid #27ae60;
}

.status-محجوز {
    background: linear-gradient(135deg, #f1c40f, #f39c12);
    border: 1px solid #f39c12;
}

.status-مباع {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    border: 1px solid #c0392b;
}

.status-badge::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.1);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.property-card:hover .status-badge::after {
    opacity: 1;
}

.property-image {
    height: 200px;
    overflow: hidden;
}

.property-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.property-card:hover .property-image img {
    transform: scale(1.1);
}

.property-content {
    padding: 20px;
}

.property-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #0a2640;
}

.property-location {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 15px;
}

.property-location i {
    margin-left: 5px;
    color: #1a73e8;
}

.property-price {
    margin-bottom: 20px;
}

.property-price .amount {
    font-size: 1.4rem;
    font-weight: 700;
    color: #4CAF50;
}

.property-price .currency {
    font-size: 1rem;
    color: #666;
    margin-right: 5px;
}

/* زر التفاصيل */
.details-btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 25px;
    background: #1a73e8;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.details-btn span {
    position: relative;
    z-index: 1;
    margin-left: 8px;
}

.details-btn i {
    position: relative;
    z-index: 1;
    transition: transform 0.3s ease;
}

.details-btn:hover {
    background: #1557b0;
    color: white;
}

.details-btn:hover i {
    transform: translateX(-5px);
}

/* تأثير الموجة عند الضغط */
.details-btn::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
}

.details-btn:active::after {
    width: 300px;
    height: 300px;
}

/* تحسين التجاوب */
@media (max-width: 768px) {
    .property-card {
        margin: 10px;
    }
    
    .property-title {
        font-size: 1.2rem;
    }
    
    .property-price .amount {
        font-size: 1.2rem;
    }
    
    .status-badge {
        font-size: 12px;
        padding: 4px 25px;
        left: -25px;
        top: 15px;
    }
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

/* إضافة ستايلات الإحصائيات */
.statistics {
    position: relative;
    overflow: hidden;
    background-color: #0a2640;
    padding: 100px 0;
    min-height: 500px;
}

.city-line {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 150px; /* زيادة ارتفاع الرسومات */
    opacity: 0.15;
}

.city-svg {
    width: 100%;
    height: 100%;
}

.building {
    fill: #2c3e50;
    transition: fill 0.3s;
}

.building:hover {
    fill: #3498db;
}

.building-detail {
    fill: #34495e;
}

/* تحريك المباني */
@keyframes cityAnimation {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-100%);
    }
}

.city-line {
    animation: cityAnimation 40s linear infinite;
}

/* تكرار المباني */
.city-line::after {
    content: '';
    position: absolute;
    top: 0;
    left: 100%;
    width: 100%;
    height: 100%;
    background: inherit;
    animation: cityAnimation 40s linear infinite;
    animation-delay: -20s;
}

/* إضافة تأثير النجوم المتحركة */
.statistics::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-image: 
        radial-gradient(white 1px, transparent 1px),
        radial-gradient(white 1px, transparent 1px);
    background-size: 50px 50px;
    background-position: 0 0, 25px 25px;
    opacity: 0.1;
    animation: starsAnimation 100s linear infinite;
}

@keyframes starsAnimation {
    from {
        transform: translateY(0);
    }
    to {
        transform: translateY(-50px);
    }
}

.stat-item {
    position: relative;
    z-index: 2;
    padding: 20px;
    transition: transform 0.3s;
}

.counter {
    font-size: 4rem;
    font-weight: bold;
}

.counter::before {
    content: '+';
    font-size: 0.7em;
    position: absolute;
    top: 0;
    right: -20px;
}

@media (max-width: 768px) {
    .counter {
        font-size: 3rem;
    }
    
    .statistics {
        padding: 60px 0;
    }
}

/* تعديل لون النص في حقول البحث */
.search-input-group .form-control,
.search-input-group .form-select {
    height: 55px;
    background: rgba(255, 255, 255, 0.9); /* خلفية شبه شفافة بيضاء */
    border: none;
    padding-left: 45px;
    color: #000000; /* لون النص أسود */
    font-size: 1rem;
}

/* تعديل لون placeholder */
.search-input-group .form-control::placeholder {
    color: rgba(0, 0, 0, 0.6); /* لون رمادي غامق */
}

/* تعديل لون النص في القائمة المنسدلة */
.search-input-group .form-select option {
    color: #000000;
    background: #ffffff;
}

/* تعديل لون الأيقونات */
.search-input-group i {
    color: #000000; /* لون أسود للأيقونات */
    opacity: 0.7;
}

/* تعديل لون السهم في القائمة المنسدلة */
.form-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23000000' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3E%3C/svg%3E");
}

/* تحسين التباين عند التركيز */
.search-input-group .form-control:focus,
.search-input-group .form-select:focus {
    background: rgba(255, 255, 255, 1);
    box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');
    const speed = 200; // سرعة العد

    const startCounting = (element) => {
        const target = parseInt(element.getAttribute('data-target'));
        let count = 0;
        const increment = target / speed;

        const updateCount = () => {
            count += increment;
            if (count < target) {
                element.innerText = Math.ceil(count);
                requestAnimationFrame(updateCount);
            } else {
                element.innerText = target;
            }
        };

        updateCount();
    };

    // بدء العد عندما يصبح العنصر مرئياً
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                startCounting(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => observer.observe(counter));
});
</script>
@endpush