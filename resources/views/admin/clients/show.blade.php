@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h6>تفاصيل طلب العميل</h6>
                        <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary btn-sm">رجوع</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- بيانات العميل -->
                        <div class="col-md-6">
                            <h6 class="mb-3">بيانات العميل</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>الاسم</th>
                                        <td>{{ $client->name_clint }}</td>
                                    </tr>
                                    <tr>
                                        <th>رقم الهاتف</th>
                                        <td>{{ $client->phone_clint }}</td>
                                    </tr>
                                    <tr>
                                        <th>البريد الإلكتروني</th>
                                        <td>{{ $client->email_clint ?: 'غير متوفر' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- بيانات الوحدة -->
                        <div class="col-md-6">
                            <h6 class="mb-3">بيانات الوحدة</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>نوع الوحدة</th>
                                        <td>{{ $client->type_unite }}</td>
                                    </tr>
                                    <tr>
                                        <th>السعر</th>
                                        <td>{{ number_format($client->price_unite) }} جنيه</td>
                                    </tr>
                                    <tr>
                                        <th>الحالة</th>
                                        <td>
                                            <select class="form-select status-select" 
                                                    data-client-id="{{ $client->id }}">
                                                <option value="متاح" {{ $client->status_unite == 'متاح' ? 'selected' : '' }}>متاح</option>
                                                <option value="محجوز" {{ $client->status_unite == 'محجوز' ? 'selected' : '' }}>محجوز</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- صور الوحدة -->
                        <div class="col-12 mt-4">
                            <h6 class="mb-3">صور الوحدة</h6>
                            <div class="row g-3">
                                @foreach($client->images as $image)
                                <div class="col-md-3">
                                    <a href="{{ asset('storage/' . $image->image_path) }}" 
                                       target="_blank">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             class="img-fluid rounded shadow-sm" 
                                             alt="صورة الوحدة">
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// تحديث حالة الطلب
document.querySelectorAll('.status-select').forEach(select => {
    select.addEventListener('change', function() {
        const clientId = this.dataset.clientId;
        const status = this.value;

        fetch(`/admin/clients/${clientId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                Swal.fire({
                    title: 'تم!',
                    text: 'تم تحديث حالة الطلب بنجاح',
                    icon: 'success',
                    confirmButtonText: 'حسناً'
                });
            }
        });
    });
});
</script>
@endpush
@endsection