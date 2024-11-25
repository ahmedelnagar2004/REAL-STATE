@extends('layouts.app')

@section('title', $unite->name)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>{{ $unite->name }}</h3>
        <div>
            <a href="{{ route('unites.edit', $unite->id) }}" class="btn btn-warning">
                تعديل
            </a>
            <a href="{{ route('unites.index') }}" class="btn btn-secondary">
                رجوع
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <!-- صور الوحدة -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="mb-3">صور الوحدة</h5>
                <div class="row">
                    @if($unite->image)
                        <div class="col-md-3 mb-3">
                            <img src="{{ asset('storage/unites/' . $unite->image) }}" 
                                 class="img-fluid rounded" 
                                 alt="صورة الوحدة">
                        </div>
                  
                    @endif
                </div>
            </div>
        </div>

        <!-- تفاصيل الوحدة -->
        <div class="row">
            <div class="col-md-8">
                <table class="table table-striped">
                    <tr>
                        <th style="width: 150px;">اسم الوحدة</th>
                        <td>{{ $unite->name }}</td>
                    </tr>
                    <tr>
                        <th>الموقع</th>
                        <td>{{ $unite->location }}</td>
                    </tr>
                    <tr>
                        <th>السعر</th>
                        <td>{{ number_format($unite->price) }} ريال</td>
                    </tr>
                    <tr>
                        <th>الوصف</th>
                        <td>{{ $unite->description }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .img-fluid {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }
    
    .table th {
        background-color: #f8f9fa;
    }
</style>
@endpush
