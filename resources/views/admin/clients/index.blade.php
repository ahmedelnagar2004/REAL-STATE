@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>طلبات العملاء</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">العميل</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">نوع الوحدة</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">السعر</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">حالة الوحدة</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">حالة الطلب</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">تاريخ الطلب</th>
                                    <th class="text-secondary opacity-7">إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $client)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $client->name_clint }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $client->phone_clint }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $client->type_unite }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ number_format($client->price_unite) }} جنيه
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="badge badge-sm bg-{{ $client->status_unite == 'متاح' ? 'success' : 'warning' }}">
                                            {{ $client->status_unite }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <select class="form-select form-select-sm status-select" 
                                                data-client-id="{{ $client->id }}"
                                                style="width: auto; margin: auto;">
                                            <option value="pending" {{ $client->request_status == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                                            <option value="accepted" {{ $client->request_status == 'accepted' ? 'selected' : '' }}>مقبول</option>
                                            <option value="rejected" {{ $client->request_status == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                                        </select>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $client->created_at->format('Y-m-d') }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('admin.clients.show', $client->id) }}" 
                                           class="btn btn-sm btn-info" 
                                           data-toggle="tooltip" 
                                           data-original-title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.status-select').forEach(select => {
    select.setAttribute('data-original-value', select.value);
    
    select.addEventListener('change', function() {
        const clientId = this.dataset.clientId;
        const status = this.value;
        const originalValue = this.getAttribute('data-original-value');
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: 'تأكيد تغيير الحالة',
            text: 'هل أنت متأكد من تغيير حالة الطلب؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، تغيير',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                // إضافة FormData
                const formData = new FormData();
                formData.append('status', status);
                formData.append('_token', token);

                // إرسال الطلب
                fetch(`/admin/clients/${clientId}/status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if(data.success) {
                        this.setAttribute('data-original-value', status);
                        Swal.fire({
                            title: 'تم!',
                            text: 'تم تحديث حالة الطلب بنجاح',
                            icon: 'success'
                        });
                    } else {
                        throw new Error(data.message || 'فشل تحديث الحالة');
                    }
                })
                .catch(error => {
                    this.value = originalValue;
                    Swal.fire({
                        title: 'خطأ!',
                        text: 'حدث خطأ أثناء تحديث الحالة',
                        icon: 'error'
                    });
                });
            } else {
                this.value = originalValue;
            }
        });
    });
});
</script>
@endpush
@endsection