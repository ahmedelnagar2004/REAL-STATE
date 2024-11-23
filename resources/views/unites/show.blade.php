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
            </div>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-warning">تعديل الحجز</a>
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">عودة للقائمة</a>
            
            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                    حذف الحجز
                </button>
            </form>
        </div>
    </div>
</div>
@endsection