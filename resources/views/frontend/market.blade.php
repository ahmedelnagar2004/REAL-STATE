@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-primary">قائمة العملاء</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('frontend.market.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> إضافة عميل جديد
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم العميل</th>
                                    <th>نوع الوحدة</th>
                                    <th>السعر</th>
                                    <th>الحالة</th>
                                    <th>الملف</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clients as $client)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $client->name_clint }}</td>
                                    <td>{{ $client->type_unite }}</td>
                                    <td>{{ number_format($client->price_unite) }} جنيه</td>
                                    <td>
                                        <span class="badge bg-{{ $client->status_unite == 'متاح' ? 'success' : 'warning' }}">
                                            {{ $client->status_unite }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($client->image_pdf)
                                            <a href="{{ asset('storage/' . $client->image_pdf) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('frontend.market.show', $client->id) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('frontend.market.edit', $client->id) }}" 
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="deleteClient({{ $client->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">لا يوجد عملاء حالياً</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- نموذج الحذف -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
function deleteClient(id) {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: "لا يمكن التراجع عن هذه العملية!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'نعم، احذف!',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `/market/${id}`;
            form.submit();
        }
    });
}
</script>
@endpush
@endsection