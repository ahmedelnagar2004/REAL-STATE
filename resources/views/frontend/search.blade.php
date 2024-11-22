@extends('layouts.frontend')

@section('title', 'البحث عن الوحدات')

@section('content')
<div class="container py-5">
    <!-- قسم البحث -->
    <div class="search-section mb-5">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('frontend.search') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">الموقع</label>
                            <input type="text" name="location" class="form-control" 
                                   value="{{ request('location') }}" 
                                   placeholder="ادخل الموقع">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">نطاق السعر</label>
                            <select name="price_range" class="form-select">
                                <option value="">جميع الأسعار</option>
                                <option value="1" {{ request('price_range') == '1' ? 'selected' : '' }}>
                                    أقل من مليون جنيه
                                </option>
                                <option value="2" {{ request('price_range') == '2' ? 'selected' : '' }}>
                                    من مليون إلى 2 مليون جنيه
                                </option>
                                <option value="3" {{ request('price_range') == '3' ? 'selected' : '' }}>
                                    أكثر من 2 مليون جنيه
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i> بحث
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- نتائج البحث -->
    <div class="results-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>نتائج البحث ({{ $unites->total() }})</h4>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" 
                        data-bs-toggle="dropdown">
                    ترتيب حسب
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">
                            السعر: من الأقل للأعلى
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">
                            السعر: من الأعلى للأقل
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}">
                            الأحدث
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        @if($unites->count() > 0)
            <div class="row">
                @foreach($unites as $unite)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 unit-card">
                        <img src="{{ asset('storage/' . $unite->images->first()->image) }}" 
                             class="card-img-top" alt="{{ $unite->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $unite->name }}</h5>
                            <p class="card-text text-muted">
                                <i class="fas fa-map-marker-alt"></i> {{ $unite->location }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price">{{ number_format($unite->price) }} جنيه</span>
                                <a href="{{ route('frontend.units.show', $unite) }}" 
                                   class="btn btn-outline-primary">التفاصيل</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- الترقيم -->
            <div class="d-flex justify-content-center mt-4">
                {{ $unites->appends(request()->query())->links() }}
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>
                لم يتم العثور على نتائج مطابقة لبحثك
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
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

.price {
    font-size: 1.25rem;
    font-weight: bold;
    color: #28a745;
}

.pagination {
    margin-bottom: 0;
}
</style>
@endpush
@endsection