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
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
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
        let currentUnreadCount = {{ auth()->user()->unreadNotifications->count() }};
        const badgeElement = document.querySelector('.navbar-badge');
        const headerElement = document.querySelector('.dropdown-header');
        
        @if(auth()->user()->unreadNotifications->count() > 0)
            @php
                $latestNotification = auth()->user()->unreadNotifications->first();
            @endphp
            
            @if(!session('notification_popup_shown_' . $latestNotification->id))
                @php session(['notification_popup_shown_' . $latestNotification->id => true]); @endphp
                showNotificationPopup("{{ $latestNotification->data['message'] }}", "{{ route('notifications.mark-as-read', $latestNotification->id) }}");
            @endif
        @endif

        // Real-time Polling every 2 seconds
        setInterval(function() {
            fetch("{{ route('notifications.check') }}")
                .then(response => response.json())
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
