@extends('layouts.app')

@section('title', 'إضافة وحدة جديدة')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>إضافة وحدة جديدة</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('unites.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- بيانات الوحدة -->
                <div class="col-md-6">
                    <h4>معلومات الوحدة</h4>
                    <div class="mb-3">
                        <label for="name" class="form-label">اسم الوحدة</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">تفاصيل الوحدة</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">السعر</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price') }}">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">الموقع</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" 
                               id="location" name="location" value="{{ old('location') }}">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">الحالة</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status">
                            <option value="">اختر الحالة</option>
                            <option value="متاح" {{ old('status') == 'متاح' ? 'selected' : '' }}>متاح</option>
                            <option value="محجوز" {{ old('status') == 'محجوز' ? 'selected' : '' }}>محجوز</option>
                            <option value="مباع" {{ old('status') == 'مباع' ? 'selected' : '' }}>مباع</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- قسم الصور -->
                <div class="col-md-6">
                    <h4>الصور</h4>
                    <div class="mb-3">
                        <label for="images" class="form-label">اختر الصور</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror" 
                               id="images" name="images[]" multiple accept="image/*">
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="preview" class="row mt-3">
                        <!-- سيتم عرض معاينة لصور هنا -->
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <a href="{{ route('unites.index') }}" class="btn btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // معاينة الصور قبل الرفع
    document.getElementById('images').addEventListener('change', function(e) {
        const preview = document.getElementById('preview');
        preview.innerHTML = '';
        
        for (const file of e.target.files) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-2';
                col.innerHTML = `
                    <img src="${event.target.result}" class="img-fluid rounded" alt="معاينة">
                `;
                preview.appendChild(col);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection