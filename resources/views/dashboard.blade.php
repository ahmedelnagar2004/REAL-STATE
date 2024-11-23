@extends('layouts.app')

@section('content')
    <div class="container" style="text-align: center;">
        <h1>Dashboard</h1>
      
       <a href="{{ route('unites.index') }}" class="btn btn-primary">الوحدات</a>
        <a href="{{ route('unites.create') }}" class="btn btn-success">إضافة وحدة</a>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-info">الحجوزات</a>
        
    </div>
@endsection
