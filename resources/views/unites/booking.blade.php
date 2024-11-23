@extends('layouts.app')
@section('content')

<div class="container">
    <h2 class="text-center mb-4">الوحدات المحجوزة</h2>

    <div class="row">
        @forelse ($bookings as $booking)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">وحدة رقم: {{ $booking->unite->unit_number }}</h5>
                        <div class="card-text">
                            <p><strong>اسم المستأجر:</strong> {{ $booking->tenant_name }}</p>
                            <p><strong>تاريخ الحجز:</strong> {{ $booking->booking_date }}</p>
                            <p><strong>تاريخ بداية الإيجار:</strong> {{ $booking->start_date }}</p>
                            <p><strong>تاريخ نهاية الإيجار:</strong> {{ $booking->end_date }}</p>
                            <p><strong>قيمة الإيجار:</strong> {{ $booking->rent_amount }} ريال</p>
                            <p><strong>حالة الحجز:</strong> 
                                <span class="badge {{ $booking->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $booking->status == 'active' ? 'نشط' : 'منتهي' }}
                                </span>
                            </p>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-primary">عرض التفاصيل</a>
                            <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-warning">تعديل</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="alert alert-info">لا توجد حجوزات حالياً</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $bookings->links() }}
    </div>
</div>

<!-- إضافة النموذج قبل نهاية القسم -->
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">حجز الوحدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form method="POST" action="{{ route('frontend.bookings.store') }}" id="bookingForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="unite_id" value="{{ $unite->id }}">
                    
                    <div class="mb-3">
                        <label class="form-label">الاسم</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="tel" name="phone" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control"></textarea>
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
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        console.log('Form submitted');
        
        let formData = new FormData(form);
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                let modal = bootstrap.Modal.getInstance(document.getElementById('bookingModal'));
                modal.hide();
                
                alert(data.message);
                
                window.location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء الحجز');
        });
    });
});
</script>
@endpush

@endsection
