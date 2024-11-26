@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">تسويق وحدة عقارية</h3>
                </div>
                <div class="card-body">
                    <form id="marketForm" method="POST" action="{{ route('frontend.market.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- بيانات العميل -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">اسم العميل</label>
                                <input type="text" name="name_clint" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">رقم الهاتف</label>
                                <input type="text" name="phone_clint" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" name="email_clint" class="form-control">
                            </div>
                        </div>

                        <!-- بيانات الوحدة -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">نوع الوحدة</label>
                                <select name="type_unite" class="form-select" required>
                                    <option value="">اختر نوع الوحدة</option>
                                    <option value="شقة">شقة</option>
                                    <option value="فيلا">فيلا</option>
                                    <option value="محل">محل تجاري</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">السعر</label>
                                <input type="number" name="price_unite" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">الحالة</label>
                                <select name="status_unite" class="form-select" required>
                                    <option value="">اختر الحالة</option>
                                    <option value="للبيع">للبيع</option>
                                    <option value="للايجار">للايجار</option>
                                </select>
                            </div>
                        </div>

                        <!-- صور الوحدة -->
                        <div class="mb-4">
                            <label class="form-label">صور الوحدة</label>
                            <input type="file" name="unit_images[]" class="form-control" multiple required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5">إرسال الطلب</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('marketForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // عرض رسالة النجاح
            Swal.fire({
                title: 'تم استلام طلبك',
                text: 'سيتم مراجعة الطلب الخاص بك',
                icon: 'success',
                confirmButtonText: 'حسناً'
            }).then((result) => {
                // الرجوع للصفحة الرئيسية
                window.location.href = '{{ route('frontend.home') }}';
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'خطأ!',
            text: 'حدث خطأ أثناء إرسال الطلب',
            icon: 'error',
            confirmButtonText: 'حسناً'
        });
    });
});
</script>
@endpush
@endsection