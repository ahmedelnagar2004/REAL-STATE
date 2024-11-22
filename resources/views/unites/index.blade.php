@extends('layouts.app')

@section('title', 'قائمة الوحدات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>قائمة الوحدات</h2>
    <a href="{{ route('unites.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> إضافة وحدة جديدة
    </a>
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
                        <i class="fas fa-edit"></i> تعديل
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