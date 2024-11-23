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
                <h5>تفاصيل الوحدة</h5>
                <p><strong>رقم الوحدة:</strong> {{ $unite->unit_number }}</p>
                <!-- معلومات إضافية عن الوحدة -->
            </div>
            <div class="col-md-6">
                <h5>تفاصيل الحجز</h5>
                @if(isset($booking))
                    <p><strong>اسم المستأجر:</strong> {{ $booking->tenant_name }}</p>
                    <p><strong>تاريخ الحجز:</strong> {{ $booking->booking_date }}</p>
                    <p><strong>تاريخ البداية:</strong> {{ $booking->start_date }}</p>
                    <p><strong>تاريخ النهاية:</strong> {{ $booking->end_date }}</p>
                    <p><strong>قيمة الإيجار:</strong> {{ $booking->rent_amount }} ريال</p>
                    <p><strong>الحالة:</strong> 
                        <span class="badge {{ $booking->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                            {{ $booking->status == 'active' ? 'نشط' : 'منتهي' }}
                        </span>
                    </p>
                @else
                    <p>لا يوجد حجوزات لهذه الوحدة</p>
                @endif
            </div>
        </div>
        
        <div class="mt-4">
            @if(isset($booking))
                <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-warning">
                    تعديل الحجز
                </a>
                
                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                        حذف الحجز
                    </button>
                </form>
            @else
                <div class="alert alert-info">
                    لا يوجد حجز لهذه الوحدة
                </div>
            @endif
            
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                عودة للقائمة
            </a>
        </div>
    </div>
</div>

<!-- نموذج الحجز المنبثق -->
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">حجز الوحدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form id="bookingForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="unite_id" value="{{ $unite->id }}">
                    
                    <div class="mb-3">
                        <label class="form-label">الاسم</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="tel" name="phone" id="phone" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" id="notes" class="form-control"></textarea>
                    </div>

                    <!-- تفاصيل الوحدة -->
                    <div class="mt-3 bg-light p-3 rounded">
                        <h6>تفاصيل الوحدة:</h6>
                        <p>نوع العقار: {{ $unite->type }}</p>
                        <p>السعر: {{ number_format($unite->price) }} جنيه</p>
                        <p>الموقع: {{ $unite->address }}</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">تأكيد الحجز</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('bookingForm');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            
            console.log('Sending data:', data); // للتأكد من البيانات قبل إرسالها
            
            const response = await fetch('{{ route("frontend.bookings.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            
            if (!response.ok) {
                throw new Error(result.message || 'حدث خطأ في عملية الحجز');
            }

            if (result.success) {
                alert('تم الحجز بنجاح');
                const modal = bootstrap.Modal.getInstance(document.getElementById('bookingModal'));
                modal.hide();
                window.location.reload();
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('حدث خطأ في عملية الحجز: ' + error.message);
        }
    });
});
</script>
@endpush

@endsection