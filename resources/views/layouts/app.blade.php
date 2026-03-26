<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $appName ?? config('app.name', 'PR System') }}</title>

    @if(isset($appFavicon) && $appFavicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $appFavicon) }}">
    @endif

    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- TomSelect -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <style>
        /* Fix Tailwind & Bootstrap Conflict */
        .collapse.show { visibility: visible !important; }
        @media (min-width: 992px) {
            .navbar-expand-lg .navbar-collapse {
                visibility: visible !important;
                display: flex !important;
            }
        }

        body, font-family {
            font-family: 'Inter', sans-serif !important;
        }

        @supports (padding: max(0px)) {
            .content-wrapper {
                padding-bottom: env(safe-area-inset-bottom);
            }
        }

        /* --- MODERN ELEGANT DARK/BLUE THEME OVERRIDES --- */
        body.dark-mode {
            background-color: #0f172a !important; /* Tailwind slate-900 */
            color: #f8fafc !important;
            letter-spacing: 0.2px;
        }
        
        /* Navbar Glassmorphism */
        .glass-navbar {
            background-color: rgba(15, 23, 42, 0.75) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            z-index: 1050;
        }
        .dark-mode .navbar-brand {
            color: #ffffff !important;
            font-weight: 700;
        }
        .dark-mode .navbar-nav .nav-link {
            color: #cbd5e1 !important;
            font-weight: 500;
            padding: 0.5rem 1.25rem !important; /* Balanced elegant lateral spacing */
            border-radius: 8px;
            transition: all 0.2s ease;
            white-space: nowrap; /* Prevent icon/text wrapping */
            display: flex;
            align-items: center;
        }
        .dark-mode .navbar-nav .nav-link:hover,
        .dark-mode .navbar-nav .nav-link.active {
            color: #3b82f6 !important; /* Premium Blue */
            background-color: rgba(59, 130, 246, 0.1) !important;
        }
        
        /* Content Wrapper */
        .dark-mode .content-wrapper, .dark-mode .main-footer {
            background-color: transparent !important;
            border-top: none !important;
        }

        /* Cards & Panels */
        .dark-mode .card,
        .dark-mode .info-box,
        .dark-mode .small-box {
            background-color: #1e293b !important; /* Tailwind slate-800 */
            border: 1px solid rgba(255,255,255,0.05) !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -2px rgba(0, 0, 0, 0.1) !important;
            color: #f1f5f9 !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .dark-mode .card-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            background-color: transparent !important;
            padding: 1.25rem 1.5rem;
        }

        /* Typography & Tailwind Overrides for Dark Mode */
        .dark-mode h1, .dark-mode h2, .dark-mode h3, 
        .dark-mode h4, .dark-mode h5, .dark-mode h6,
        .dark-mode .text-dark, .dark-mode .text-body,
        .dark-mode .text-gray-900, .dark-mode .text-gray-800, .dark-mode .text-gray-700 {
            color: #f8fafc !important;
        }
        .dark-mode label, 
        .dark-mode .form-group label,
        .dark-mode .text-gray-600, .dark-mode .text-gray-500 {
            color: #cbd5e1 !important;
            font-weight: 500;
        }

        /* Essential Blue Accents */
        .text-primary, .text-info {
            color: #3b82f6 !important;
        }
        .dark-mode .bg-primary, 
        .dark-mode .btn-primary {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.4);
        }
        .dark-mode .btn-primary:hover {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 8px -1px rgba(59, 130, 246, 0.5);
        }

        /* Buttons Core */
        .dark-mode .btn {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
            letter-spacing: 0.3px;
        }
        
        /* Tables */
        .dark-mode .table {
            color: #e2e8f0;
        }
        .dark-mode .table thead th {
            border-bottom: 1px solid rgba(255,255,255,0.08) !important;
            border-top: none !important;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 1rem;
        }
        .dark-mode .table td, .dark-mode .table th {
            border-color: rgba(255,255,255,0.05) !important;
            vertical-align: middle;
            padding: 1rem;
        }
        .dark-mode .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.015) !important;
        }
        .dark-mode .table-hover tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.05) !important;
        }
        
        /* Forms & Inputs */
        .dark-mode .form-control,
        .dark-mode .custom-select,
        .dark-mode input[type="text"],
        .dark-mode input[type="email"],
        .dark-mode input[type="password"],
        .dark-mode input[type="number"],
        .dark-mode input[type="file"],
        .dark-mode textarea {
            background-color: #0f172a !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #f8fafc !important;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            height: auto !important;
            line-height: 1.5;
        }
        .dark-mode .form-control:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
        }
        
        /* Status Badges */
        .dark-mode .badge {
            border-radius: 8px;
            padding: 6px 12px;
            font-weight: 600;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
        }
        .dark-mode .badge-success { background-color: rgba(16, 185, 129, 0.15) !important; color: #34d399 !important; border: 1px solid rgba(16,185,129,0.2) !important; }
        .dark-mode .badge-warning { background-color: rgba(245, 158, 11, 0.15) !important; color: #fbbf24 !important; border: 1px solid rgba(245,158,11,0.2) !important; }
        .dark-mode .badge-info    { background-color: rgba(56, 189, 248, 0.15) !important; color: #38bdf8 !important; border: 1px solid rgba(56,189,248,0.2) !important; }
        .dark-mode .badge-danger  { background-color: rgba(239, 68, 68, 0.15) !important; color: #f87171 !important; border: 1px solid rgba(239,68,68,0.2) !important; }

        /* Dropdown Menus */
        .dark-mode .dropdown-menu {
            background-color: #1e293b !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            padding: 0.5rem;
        }
        .dark-mode .dropdown-item {
            color: #cbd5e1 !important;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            margin-bottom: 2px;
            transition: all 0.2s;
        }
        .dark-mode .dropdown-item:hover, .dark-mode .dropdown-item:focus {
            background-color: rgba(59, 130, 246, 0.1) !important;
            color: #3b82f6 !important;
        }
        .dark-mode .dropdown-divider {
            border-top: 1px solid rgba(255,255,255,0.05);
            margin: 0.5rem 0;
        }

        .dark-mode .text-muted { color: #64748b !important; }
    </style>
</head>

<body class="hold-transition layout-top-nav dark-mode">
<div class="wrapper">

    <!-- Top Navbar -->
    <nav class="main-header navbar navbar-expand-lg navbar-dark glass-navbar sticky-top">
        <div class="container-fluid px-4">
            <a href="{{ route('dashboard') }}" class="navbar-brand d-flex align-items-center">
                @if(isset($appLogo) && $appLogo)
                    <img src="{{ asset('storage/' . $appLogo) }}" alt="Logo" class="brand-image rounded-lg mr-2" style="opacity: 1; height: 36px; width: 36px; object-fit: contain;">
                @else
                    <div class="bg-primary rounded-lg d-flex align-items-center justify-content-center mr-2 shadow-sm" style="width: 36px; height: 36px;">
                        <i class="fas fa-layer-group text-white"></i>
                    </div>
                @endif
                <span class="brand-text font-weight-bold" style="letter-spacing: 1px;">{{ $appName ?? 'PR System' }}</span>
            </a>

            <button class="navbar-toggler order-1 border-0" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav ml-4">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fas fa-chart-pie mr-1"></i> Dashboard</a>
                    </li>

                    @can('view pr')
                    <li class="nav-item dropdown">
                        <a id="dropdownPR" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ request()->routeIs('purchase-requests.*') ? 'active' : '' }}"><i class="fas fa-shopping-bag mr-1"></i> Purchase Requests</a>
                        <ul aria-labelledby="dropdownPR" class="dropdown-menu border-0 shadow">
                            @can('create pr')
                            <li><a href="{{ route('purchase-requests.create') }}" class="dropdown-item"><i class="fas fa-plus-circle mr-2 text-primary"></i> Create PR</a></li>
                            <li><a href="{{ route('purchase-requests.drafts') }}" class="dropdown-item"><i class="fas fa-file-alt mr-2 text-secondary"></i> Draft PRs</a></li>
                            <div class="dropdown-divider"></div>
                            @endcan
                            
                            @if(Auth::user()->hasAnyRole(['operational_manager', 'general_manager', 'superadmin']))
                            <li><a href="{{ route('purchase-requests.approvals') }}" class="dropdown-item"><i class="fas fa-user-check mr-2 text-success"></i> Approval Queue</a></li>
                            @endif
                            <li><a href="{{ route('purchase-requests.index') }}" class="dropdown-item"><i class="fas fa-list mr-2 text-info"></i> All Requests</a></li>
                            
                            @php
                                $rejectedCount = \App\Models\PurchaseRequest::where('user_id', Auth::id())
                                    ->whereHas('items', function($q) {
                                        $q->whereIn('status', ['rejected_om', 'rejected_gm', 'rejected_proc']);
                                    })->count();
                            @endphp
                            <li>
                                <a href="{{ route('purchase-requests.rejected') }}" class="dropdown-item">
                                    <i class="fas fa-exclamation-circle mr-2 text-danger"></i> Needs Revision
                                    @if($rejectedCount > 0)
                                        <span class="badge badge-danger float-right mt-1">{{ $rejectedCount }}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcan

                    @can('manage users')
                    <li class="nav-item dropdown">
                        <a id="dropdownUsers" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ request()->routeIs('users.*') ? 'active' : '' }}"><i class="fas fa-users mr-1"></i> Users</a>
                        <ul aria-labelledby="dropdownUsers" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('users.index') }}" class="dropdown-item">All Users</a></li>
                            <li><a href="{{ route('users.create') }}" class="dropdown-item">Add User</a></li>
                        </ul>
                    </li>
                    @endcan

                    @can('manage departments')
                    <li class="nav-item dropdown">
                        <a id="dropdownDepts" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ request()->routeIs('departments.*') ? 'active' : '' }}"><i class="fas fa-building mr-1"></i> Departments</a>
                        <ul aria-labelledby="dropdownDepts" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('departments.index') }}" class="dropdown-item">All Departments</a></li>
                            <li><a href="{{ route('departments.create') }}" class="dropdown-item">Add Department</a></li>
                        </ul>
                    </li>
                    @endcan

                    @can('view reports')
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"><i class="fas fa-chart-line mr-1"></i> Reports</a>
                    </li>
                    @endcan

                    @if(Auth::user()->hasRole('superadmin'))
                    <li class="nav-item dropdown">
                        <a id="dropdownSettings" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ request()->routeIs('settings.*') || request()->routeIs('uoms.*') || request()->routeIs('purposes.*') ? 'active' : '' }}"><i class="fas fa-cogs mr-1"></i> Settings</a>
                        <ul aria-labelledby="dropdownSettings" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('settings.general') }}" class="dropdown-item">General Settings</a></li>
                            <li><a href="{{ route('uoms.index') }}" class="dropdown-item">UOM Management</a></li>
                            <li><a href="{{ route('purposes.index') }}" class="dropdown-item">Purpose Management</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto align-items-center">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown mr-2">
                    <a class="nav-link" data-toggle="dropdown" href="#" style="position: relative;">
                        <i class="far fa-bell" style="font-size: 1.2rem;"></i>
                        <span class="badge badge-danger navbar-badge notification-bubble" style="{{ auth()->user()->unreadNotifications->count() > 0 ? '' : 'display: none;' }}">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow-lg border-0" style="min-width: 320px;">
                        <span class="dropdown-item dropdown-header text-center py-3 bg-light text-dark font-weight-bold" style="border-radius: 12px 12px 0 0;">{{ auth()->user()->unreadNotifications->count() }} Notifications</span>
                        <div class="dropdown-divider m-0"></div>
                        <div style="max-height: 350px; overflow-y: auto;">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <a href="{{ route('notifications.mark-as-read', $notification->id) }}" class="dropdown-item py-3 text-wrap">
                                    <div class="d-flex">
                                        <div class="mr-3 mt-1">
                                            <div class="bg-primary bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                <i class="fas fa-envelope text-primary"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm mb-1" style="white-space: normal; line-height: 1.4;">{{ $notification->data['message'] }}</p>
                                            <p class="text-xs text-muted mb-0"><i class="far fa-clock mr-1"></i> {{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-divider m-0"></div>
                            @empty
                                <div class="dropdown-item text-center text-muted py-4">No new notifications</div>
                            @endforelse
                        </div>
                        <a href="{{ route('notifications.index') }}" class="dropdown-item dropdown-footer text-center py-3 text-primary font-weight-bold" style="border-radius: 0 0 12px 12px;">See All Notifications</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#" style="background: rgba(255,255,255,0.05); border-radius: 50px; padding: 0.3rem 0.5rem 0.3rem 1rem; border: 1px solid rgba(255,255,255,0.1);">
                        <div class="d-none d-md-block text-right mr-3">
                            <div class="text-sm font-weight-bold text-white">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-primary">{{ ucfirst(str_replace('_', ' ', Auth::user()->getRoleNames()->first())) }}</div>
                        </div>
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                            <i class="fas fa-user text-white"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-2">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item py-2">
                            <i class="fas fa-user-circle mr-3 text-muted"></i> My Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="dropdown-item py-2 text-danger" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-3"></i> Logout
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        </div>
    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header py-4">
            <div class="container-fluid px-4">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        @isset($header)
                            <h1 class="m-0 text-white font-weight-bold" style="font-size: 1.8rem;">{{ $header }}</h1>
                        @else
                            @yield('header')
                        @endisset
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid px-4 pb-5">
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </div>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer border-top-0 mt-auto py-4 text-center">
        <div class="container-fluid px-4">
            <div class="text-muted text-sm">
                <strong>Copyright &copy; {{ date('Y') }} {{ $appName ?? 'PR System' }}.</strong> All rights reserved.
                <span class="mx-2">|</span> Designed for Efficiency
            </div>
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<style>
    .notification-bubble {
        position: absolute;
        top: 2px;
        right: 0px;
        border-radius: 50%;
        padding: 0.25em 0.4em;
        font-size: 0.6rem;
        line-height: 1;
        background-color: #ef4444 !important;
        border: 2px solid #0f172a;
    }
</style>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                background: '#1e293b',
                color: '#f8fafc',
                iconColor: '#34d399'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                background: '#1e293b',
                color: '#f8fafc',
                iconColor: '#f87171'
            });
        @endif

        let currentUnreadCount = {{ auth()->user()->unreadNotifications->count() }};
        
        @if(auth()->user()->unreadNotifications->count() > 0)
            @php
                $latestNotification = auth()->user()->unreadNotifications->first();
            @endphp
            
            @if(!session('notification_popup_shown_' . $latestNotification->id))
                @php session(['notification_popup_shown_' . $latestNotification->id => true]); @endphp
                showNotificationPopup(@json($latestNotification->data['message']), "{{ route('notifications.mark-as-read', $latestNotification->id) }}");
            @endif
        @endif

        setInterval(function() {
            fetch("{{ route('notifications.check') }}", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Accept": "application/json"
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.unread_count > currentUnreadCount && data.latest) {
                        showNotificationPopup(data.latest.message, data.latest.url);
                    }
                    
                    if (data.unread_count != currentUnreadCount) {
                        currentUnreadCount = data.unread_count;
                        const badge = document.querySelector('.navbar-badge');
                        const header = document.querySelector('.dropdown-header');
                        
                        if (badge) {
                            badge.textContent = data.unread_count;
                            badge.style.display = data.unread_count > 0 ? 'inline-block' : 'none';
                        }
                        if (header) {
                            header.textContent = data.unread_count + " Notifications";
                        }
                    }
                })
                .catch(error => console.error('Error checking notifications:', error));
        }, 2000);

        document.querySelectorAll('.form-confirm').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const message = this.getAttribute('data-message') || 'Are you sure?';
                
                Swal.fire({
                    title: 'Konfirmasi',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal',
                    background: '#1e293b',
                    color: '#f8fafc'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        function showNotificationPopup(message, url) {
            Swal.fire({
                title: 'Notifikasi Baru',
                text: message,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Lihat Detail',
                cancelButtonText: 'Tutup',
                toast: true,
                position: 'top-end',
                timer: 10000,
                timerProgressBar: true,
                background: '#1e293b',
                color: '#f8fafc',
                iconColor: '#3b82f6',
                confirmButtonColor: '#3b82f6'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    });
</script>

</body>
</html>
