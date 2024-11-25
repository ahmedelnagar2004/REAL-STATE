@extends('layouts.admin')

@section('title', 'تعديل الوحدة - ' . $unite->name)

@section('content')
<div class="card">
    <div class="card-header">
        <h3>تعديل الوحدة: {{ $unite->name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('unites.update', $unite) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <!-- اسم الوحدة -->
                    <div class="mb-3">
                        <label for="name" class="form-label">اسم الوحدة</label>
                        <input type="text" name="name" id="name" 
                               class="form-control" 
                               value="{{ old('name', $unite->name) }}" required>
                    </div>

                    <!-- الوصف -->
                    <div class="mb-3">
                        <label for="description" class="form-label">الوصف</label>
                        <textarea name="description" id="description" 
                                  class="form-control" rows="4" required>{{ old('description', $unite->description) }}</textarea>
                    </div>

                    <!-- السعر -->
                    <div class="mb-3">
                        <label for="price" class="form-label">السعر</label>
                        <input type="number" name="price" id="price" 
                               class="form-control" 
                               value="{{ old('price', $unite->price) }}" required>
                    </div>

                    <!-- الموقع -->
                    <div class="mb-3">
                        <label for="location" class="form-label">الموقع</label>
                        <input type="text" name="location" id="location" 
                               class="form-control" 
                               value="{{ old('location', $unite->location) }}" required>
                    </div>

                    <!-- الحالة -->
                    <div class="mb-3">
                        <label for="status" class="form-label">الحالة</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="متاح" {{ $unite->status == 'متاح' ? 'selected' : '' }}>متاح</option>
                            <option value="محجوز" {{ $unite->status == 'محجوز' ? 'selected' : '' }}>محجوز</option>
                            <option value="مباع" {{ $unite->status == 'مباع' ? 'selected' : '' }}>مباع</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- الصور -->
                    <div class="mb-3">
                        <label for="images" class="form-label">إضافة صور جديدة</label>
                        <input type="file" name="images[]" id="images" 
                               class="form-control" multiple accept="image/*">
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                <a href="{{ route('unites.show', $unite) }}" class="btn btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .position-relative {
        overflow: hidden;
    }
    .position-relative img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    .position-relative form {
        margin: 5px;
    }
</style>
@endpush

@push('scripts')
<script>
    // معاينة الصور الجديدة قبل الرفع
    document.getElementById('images').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        for (const file of e.target.files) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const col = document.createElement('div');
                col.className = 'col-6 mb-2';
                col.innerHTML = `
                    <div class="position-relative">
                        <img src="${event.target.result}" 
                             class="img-fluid rounded" 
                             alt="معاينة">
                    </div>
                `;
                preview.appendChild(col);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection