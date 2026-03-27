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

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
        @supports (padding: max(0px)) {
            .content-wrapper {
                padding-bottom: env(safe-area-inset-bottom);
            }
        }

        /* --- MODERN DARK THEME OVERRIDES --- */
        body.dark-mode {
            background-color: #1a1d24 !important;
            color: #e0e6ed !important;
        }

        /* Navbar & Sidebar */
        .dark-mode .main-header,
        .dark-mode .main-sidebar {
            background-color: #1e2128 !important;
            border-bottom: none !important;
            border-right: none !important;
        }

        .dark-mode .navbar-light .navbar-nav .nav-link {
            color: #a0aec0;
        }

        /* Content Wrapper */
        .dark-mode .content-wrapper {
            background-color: #1a1d24 !important;
        }

        /* Cards & Panels */
        .dark-mode .card,
        .dark-mode .info-box,
        .dark-mode .small-box {
            background-color: #222630 !important;
            border: none !important;
            border-radius: 15px !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
            color: #e0e6ed !important;
        }

        .dark-mode .card-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            background-color: transparent !important;
        }

        /* Primary Accents */
        .dark-mode .bg-primary,
        .dark-mode .btn-primary {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
        }

        .dark-mode .btn-primary:hover {
            background-color: #1d4ed8 !important;
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 10px rgba(37, 99, 235, 0.5);
        }

        /* Buttons & Badges */
        .dark-mode .btn {
            border-radius: 8px;
        }

        /* Tables */
        .dark-mode .table {
            color: #e0e6ed;
        }

        .dark-mode .table thead th {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            border-top: none !important;
            font-weight: 600;
            color: #a0aec0;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .dark-mode .table td,
        .dark-mode .table th {
            border-color: rgba(255, 255, 255, 0.05) !important;
            vertical-align: middle;
        }

        .dark-mode .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.02) !important;
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
            background-color: #1a1d24 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #e0e6ed !important;
            border-radius: 8px;
        }

        .dark-mode .form-control:focus,
        .dark-mode input[type="text"]:focus,
        .dark-mode input[type="email"]:focus,
        .dark-mode input[type="password"]:focus,
        .dark-mode input[type="number"]:focus,
        .dark-mode textarea:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25) !important;
            outline: none !important;
        }

        /* Status Badges */
        .dark-mode .badge {
            border-radius: 6px;
            padding: 5px 10px;
            font-weight: 500;
        }

        .dark-mode .badge-success,
        .dark-mode .bg-success {
            background-color: rgba(40, 167, 69, 0.15) !important;
            color: #4ade80 !important;
            border: 1px solid rgba(40, 167, 69, 0.3) !important;
        }

        .dark-mode .badge-warning,
        .dark-mode .bg-warning {
            background-color: rgba(255, 193, 7, 0.15) !important;
            color: #fbbf24 !important;
            border: 1px solid rgba(255, 193, 7, 0.3) !important;
        }

        .dark-mode .badge-info,
        .dark-mode .bg-info {
            background-color: rgba(23, 162, 184, 0.15) !important;
            color: #38bdf8 !important;
            border: 1px solid rgba(23, 162, 184, 0.3) !important;
        }

        .dark-mode .badge-danger,
        .dark-mode .bg-danger {
            background-color: rgba(220, 53, 69, 0.15) !important;
            color: #f87171 !important;
            border: 1px solid rgba(220, 53, 69, 0.3) !important;
        }

        /* --- TEXT CONTRAST OVERRIDES --- */
        .dark-mode .text-muted,
        .dark-mode .text-secondary {
            color: #94a3b8 !important;
            /* Lighter cool-gray for readability */
        }

        .dark-mode .text-dark,
        .dark-mode .text-gray-900,
        .dark-mode .text-gray-800 {
            color: #f8fafc !important;
            /* Very light gray / nearly white */
        }

        .dark-mode .text-gray-600,
        .dark-mode .text-gray-500 {
            color: #cbd5e1 !important;
            /* Light-medium gray */
        }

        .dark-mode label,
        .dark-mode .form-label {
            color: #e2e8f0 !important;
            font-weight: 500;
        }

        .dark-mode h1,
        .dark-mode h2,
        .dark-mode h3,
        .dark-mode h4,
        .dark-mode h5,
        .dark-mode h6,
        .dark-mode .h1,
        .dark-mode .h2,
        .dark-mode .h3,
        .dark-mode .h4,
        .dark-mode .h5,
        .dark-mode .h6 {
            color: #f8fafc !important;
        }

        /* Pagination text contrast */
        .dark-mode .page-link {
            background-color: #222630 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #e2e8f0 !important;
        }

        .dark-mode .page-item.active .page-link {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
        }

        .dark-mode .page-item.disabled .page-link {
            color: #64748b !important;
            background-color: #1a1d24 !important;
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        /* Fix TomSelect option text color when active/selected to ensure contrast against primary blue */
        .dark-mode .ts-dropdown .option.active,
        .dark-mode .ts-dropdown .option:hover {
            background-color: #2563eb !important;
            color: #ffffff !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed dark-mode">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge" style="{{ auth()->user()->unreadNotifications->count() > 0 ? '' : 'display: none;' }}">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">{{ auth()->user()->unreadNotifications->count() }} Notifications</span>
                        <div class="dropdown-divider"></div>
                        <div style="max-height: 300px; overflow-y: auto;">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                            <a href="{{ route('notifications.mark-as-read', $notification->id) }}" class="dropdown-item">
                                <i class="fas fa-envelope mr-2"></i> {{ Str::limit($notification->data['message'], 30) }}
                                <span class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            @empty
                            <span class="dropdown-item text-center text-muted">No new notifications</span>
                            <div class="dropdown-divider"></div>
                            @endforelse
                        </div>
                        <a href="{{ route('notifications.index') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>

                </li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i> {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fas fa-user-circle mr-2"></i> My Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            @isset($header)
                            {{ $header }}
                            @else
                            @yield('header')
                            @endisset
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @isset($slot)
                    {{ $slot }}
                    @else
                    @yield('content')
                    @endisset
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.0.0
            </div>
            <strong>Copyright &copy; {{ date('Y') }} PR System.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

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
            });
            @endif

            let currentUnreadCount = {{ auth()->user()->unreadNotifications->count() }};
            const badgeElement = document.querySelector('.navbar-badge');
            const headerElement = document.querySelector('.dropdown-header');

            @if(auth()->user()->unreadNotifications->count() > 0)
            @php
            $latestNotification = auth()->user()->unreadNotifications->first();
            @endphp

            @if(!session('notification_popup_shown_' . $latestNotification->id))
            @php session(['notification_popup_shown_' . $latestNotification->id => true]); @endphp
            showNotificationPopup(@json($latestNotification->data['message']), "{{ route('notifications.mark-as-read', $latestNotification->id) }}");
            @endif
            @endif

            // Real-time Polling every 2 seconds
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
                            // New notification arrived
                            showNotificationPopup(data.latest.message, data.latest.url);
                        }

                        // Update UI elements
                        if (data.unread_count != currentUnreadCount) {
                            currentUnreadCount = data.unread_count;
                            const badge = document.querySelector('.navbar-badge');
                            const header = document.querySelector('.dropdown-header');

                            if (badge) {
                                badge.textContent = data.unread_count;
                                badge.style.display = data.unread_count > 0 ? 'inline' : 'none';
                            }
                            if (header) {
                                header.textContent = data.unread_count + " Notifications";
                            }
                        }
                    })
                    .catch(error => console.error('Error checking notifications:', error));
            }, 2000);

            // SweetAlert2 Form Confirmation Interceptor
            document.querySelectorAll('.form-confirm').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const message = this.getAttribute('data-message') || 'Are you sure?';

                    Swal.fire({
                        title: 'Konfirmasi',
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#2563eb',
                        cancelButtonColor: '#dc3545',
                        confirmButtonText: 'Ya, Lanjutkan',
                        cancelButtonText: 'Batal',
                        background: '#222630',
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