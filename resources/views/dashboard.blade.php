<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome --><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container-fluid">
        <h5 class="mb-0">لوحة التحكم</h5>
        <div class="ms-auto">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                    <div class="me-2 text-end">
                        <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                        <small class="text-muted">مدير النظام</small>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-2 rounded-circle">
                        <i class="fas fa-user text-primary"></i>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2"></i>الإعدادات</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-home fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1">إجمالي الوحدات</h6>
                            <h3 class="mb-0">{{ \App\Models\Unite::count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-calendar-check fa-2x text-success"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1">الحجوزات النشطة</h6>
                            <h3 class="mb-0">{{ \App\Models\Booking::where('status', 'active')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="fas fa-money-bill-wave fa-2x text-info"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1">إجمالي الحجوزات</h6>
                            <h3 class="mb-0">{{ \App\Models\Booking::count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-users fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1">طلبات العملاء</h6>
                            <h3 class="mb-0">{{ \App\Models\Client::count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- After the Quick Stats row and before Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">إحصائيات الحجوزات</h5>
                    <canvas id="bookingsChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <h5 class="mb-4">الإجراءات السريعة</h5>
            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('admin.bookings.index') }}" class="card bg-info bg-opacity-10 text-decoration-none h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-calendar-alt fa-2x mb-3 text-info"></i>
                            <h5 class="text-info mb-0">إدارة الحجوزات</h5>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('unites.create') }}" class="card bg-success bg-opacity-10 text-decoration-none h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-plus-circle fa-2x mb-3 text-success"></i>
                            <h5 class="text-success mb-0">إضافة وحدة جديدة</h5>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('unites.index') }}" class="card bg-primary bg-opacity-10 text-decoration-none h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-building fa-2x mb-3 text-primary"></i>
                            <h5 class="text-primary mb-0">إدارة الوحدات</h5>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('admin.clients.index') }}" class="card bg-warning bg-opacity-10 text-decoration-none h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-user-check fa-2x mb-3 text-warning"></i>
                            <h5 class="text-warning mb-0">طلبات عرض الوحدات</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</div>

@push('styles')
<style>
    .navbar {
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    
    .card {
        transition: transform 0.2s ease-in-out;
        border: none;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }

    .dropdown-menu {
        min-width: 200px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('bookingsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'الحجوزات الشهرية',
                data: {!! json_encode($data) !!},
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush