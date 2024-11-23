@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">تفاصيل الحجز رقم #{{ $booking->id }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- بيانات العميل -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">بيانات العميل</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">الاسم</th>
                            <td>{{ $booking->name }}</td>
                        </tr>
                        <tr>
                            <th>رقم الهاتف</th>
                            <td>
                                <a href="tel:{{ $booking->phone }}" class="text-decoration-none">
                                    {{ $booking->phone }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>البريد الإلكتروني</th>
                            <td>
                                <a href="mailto:{{ $booking->email }}" class="text-decoration-none">
                                    {{ $booking->email }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>تاريخ الحجز</th>
                            <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        <tr>
                            <th>حالة الحجز</th>
                            <td>
                                <span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : ($booking->status == 'approved' ? 'success' : 'danger') }}">
                                    {{ $booking->status == 'pending' ? 'قيد الانتظار' : ($booking->status == 'approved' ? 'مقبول' : 'مرفوض') }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- تفاصيل الوحدة -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">تفاصيل الوحدة</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">نوع العقار</th>
                            <td>شقه</td>
                        </tr>
                        <tr>
                            <th>العنوان</th>
                            <td>{{ $booking->unite->address ?? 'مصر ,المعادى , الحى الثامن ,الدور الثامن' }}</td>
                        </tr>
                        <tr>
                            <th>السعر</th>
                            <td>يبدأ من {{ number_format($booking->unite->price ?? 1400000) }} جنيه</td>
                        </tr>
                        <tr>
                            <th>الكود</th>
                            <td>{{ $booking->unite->code ?? 'o;awrighpGHP' }}</td>
                        </tr>
                        <tr>
                            <th>تاريخ النشر</th>
                            <td>{{ $booking->unite->created_at ? $booking->unite->created_at->format('Y F d') : 'November 2024 22' }}</td>
                        </tr>
                    </table>

                    
                </div>
            </div>
        </div>
    </div>

    <!-- الملاحظات -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">الملاحظات</h5>
                </div>
                <div class="card-body">
                    {{ $booking->notes ?? 'لا توجد ملاحظات' }}
                </div>
            </div>
        </div>
    </div>

    <!-- أزرار التحكم -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            @if($booking->status == 'pending')
                                <button class="btn btn-success me-2 update-status" 
                                        data-id="{{ $booking->id }}" 
                                        data-status="approved">
                                    <i class="fas fa-check"></i> قبول الحجز
                                </button>
                                <button class="btn btn-danger me-2 update-status" 
                                        data-id="{{ $booking->id }}" 
                                        data-status="rejected">
                                    <i class="fas fa-times"></i> رفض الحجز
                                </button>
                            @endif
                        </div>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> رجوع للقائمة
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- قسم صور الوحدة -->
   

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // تحديث حالة الحجز
    document.querySelectorAll('.update-status').forEach(button => {
        button.addEventListener('click', function() {
            const bookingId = this.dataset.id;
            const status = this.dataset.status;
            
            if(confirm('هل أنت متأكد من تغيير حالة الحجز؟')) {
                fetch(`/admin/bookings/${bookingId}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        window.location.reload();
                    } else {
                        alert('حدث خطأ أثناء تحديث الحالة');
                    }
                });
            }
        });
    });
});
</script>
@endpush

@endsection