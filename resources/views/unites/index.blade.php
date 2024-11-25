@extends('layouts.admin')

@section('title', 'قائمة الوحدات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>قائمة الوحدات</h2>
    <a href="{{ route('unites.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> إضافة وحدة جديدة
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('unites.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" 
                       placeholder="ابحث عن وحدة..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="search_by" class="form-select">
                    <option value="name" {{ request('search_by') == 'name' ? 'selected' : '' }}>الاسم</option>
                    <option value="location" {{ request('search_by') == 'location' ? 'selected' : '' }}>المكان</option>
                    <option value="price" {{ request('search_by') == 'price' ? 'selected' : '' }}>السعر</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> بحث
                </button>
            </div>
            @if(request()->has('search'))
            <div class="col-md-2">
                <a href="{{ route('unites.index') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-times"></i> إلغاء البحث
                </a>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="row">
    @foreach($unites as $unite)
    <div class="col-md-4 mb-4">
        <div class="card">
            @if($unite->images->count() > 0)
                <img src="{{ asset('storage/' . $unite->images->first()->image) }}" 
                     class="card-img-top" alt="{{ $unite->name }}"
                     style="height: 200px; object-fit: cover;">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $unite->name }}</h5>
                <p class="card-text">{{ Str::limit($unite->description, 100) }}</p>
                <p class="card-text">
                    <strong>المكان:</strong> {{ $unite->location }}
                </p>
                <p class="card-text">
                    <strong>السعر:</strong> {{ number_format($unite->price) }} جنيه
                </p>
                <p class="card-text">
                    <strong>الحالة:</strong> {{ $unite->status }}
                </p>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('unites.show', $unite) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> عرض
                    </a>
                    <a href="{{ route('unites.edit', $unite) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> تعد��ل
                    </a>
                    <form action="{{ route('unites.destroy', $unite) }}" method="POST" 
                          onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-center">
    {{ $unites->links() }}
</div>
@endsection