@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">إدارة الحجوزات</h3>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم العميل</th>
                                    <th>رقم الهاتف</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الملاحظات</th>
                                    <th>رقم الوحدة</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الحجز</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->name }}</td>
                                        <td>{{ $booking->phone }}</td>
                                        <td>{{ $booking->email }}</td>
                                        <td>{{ $booking->notes }}</td>
                                        <td>{{ $booking->unite->unit_number ?? 'غير محدد' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : ($booking->status == 'approved' ? 'success' : 'danger') }}">
                                                {{ $booking->status == 'pending' ? 'قيد الانتظار' : ($booking->status == 'approved' ? 'مقبول' : 'مرفوض') }}
                                            </span>
                                        </td>
                                        <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" 
                                                        class="btn btn-sm btn-success update-status" 
                                                        data-id="{{ $booking->id }}" 
                                                        data-status="approved">
                                                    قبول
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger update-status" 
                                                        data-id="{{ $booking->id }}" 
                                                        data-status="rejected">
                                                    رفض
                                                </button>
                                                <a href="{{ route('admin.bookings.details', $booking->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> التفاصيل
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">لا توجد حجوزات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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