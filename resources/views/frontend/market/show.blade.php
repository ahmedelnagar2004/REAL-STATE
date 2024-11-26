@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">إضافة عميل جديد</h3>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('frontend.market.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">اسم العميل</label>
                                <input type="text" 
                                       name="name_clint" 
                                       class="form-control @error('name_clint') is-invalid @enderror" 
                                       value="{{ old('name_clint') }}" 
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" 
                                       name="email_clint" 
                                       class="form-control @error('email_clint') is-invalid @enderror" 
                                       value="{{ old('email_clint') }}" 
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">رقم الهاتف</label>
                                <input type="text" 
                                       name="phone_clint" 
                                       class="form-control @error('phone_clint') is-invalid @enderror" 
                                       value="{{ old('phone_clint') }}" 
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">نوع الوحدة</label>
                                <select name="type_unite" 
                                        class="form-select @error('type_unite') is-invalid @enderror" 
                                        required>
                                    <option value="">اختر نوع الوحدة</option>
                                    <option value="شقة">شقة</option>
                                    <option value="فيلا">فيلا</option>
                                    <option value="محل">محل تجاري</option>
                                    <option value="مكتب">مكتب</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">السعر</label>
                                <input type="number" 
                                       name="price_unite" 
                                       class="form-control @error('price_unite') is-invalid @enderror" 
                                       value="{{ old('price_unite') }}" 
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">الحالة</label>
                                <select name="status_unite" 
                                        class="form-select @error('status_unite') is-invalid @enderror" 
                                        required>
                                    <option value="">اختر الحالة</option>
                                    <option value="متاح">متاح</option>
                                    <option value="محجوز">محجوز</option>
                                    <option value="مباع">مباع</option>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">الملف (PDF)</label>
                                <input type="file" 
                                       name="image_pdf" 
                                       class="form-control @error('image_pdf') is-invalid @enderror" 
                                       accept=".pdf" 
                                       required>
                                <small class="text-muted">الحد الأقصى للحجم: 10 ميجابايت</small>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('frontend.market') }}" class="btn btn-secondary">
                                رجوع
                            </a>
                            <button type="submit" class="btn btn-primary">
                                حفظ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection