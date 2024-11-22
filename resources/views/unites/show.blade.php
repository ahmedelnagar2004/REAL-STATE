@extends('layouts.app')

@section('title', $unite->name)

@section('content')
<div class="card">
    <div class="card-header">
        <h3>{{ $unite->name }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4>معلومات الوحدة</h4>
                <p><strong>السعر:</strong> {{ number_format($unite->price) }} جنيه</p>
                <p><strong>الموقع:</strong> {{ $unite->location }}</p>
                <p><strong>الحالة:</strong> {{ $unite->status }}</p>
                <p><strong>الوصف:</strong></p>
                <p>{{ $unite->description }}</p>
            </div>
            
            <div class="col-md-6">
                <h4>الصور</h4>
                <div class="row">
                    @foreach($unite->images as $image)
                    <div class="col-md-6 mb-3">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $image->image) }}" 
                                 class="img-fluid rounded" 
                                 alt="صورة الوحدة">
                            <form action="{{ route('images.delete', $image->id) }}" 
                                  method="POST" class="position-absolute top-0 end-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('هل أنت متأكد من حذف الصورة؟')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- نموذج إضافة صور جديدة -->
                <form action="{{ route('unites.addImages', $unite) }}" 
                      method="POST" enctype="multipart/form-data" class="mt-3">
                    @csrf
                    <div class="mb-3">
                        <label for="new_images" class="form-label">إضافة صور جديدة</label>
                        <input type="file" class="form-control" 
                               id="new_images" name="images[]" multiple accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">إضافة الصور</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('unites.edit', $unite) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> تعديل
        </a>
        <a href="{{ route('unites.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-right"></i> رجوع
        </a>
    </div>
</div>
@endsection