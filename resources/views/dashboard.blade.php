<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Small boxes (Stat box) -->
    <div class="row">
        @if(Auth::user()->hasRole('superadmin'))
            <div class="col-lg-3 col-6">
                <div class="card bg-info p-3 mb-4 rounded-lg shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-xs font-weight-bold mb-1 opacity-75">Total Purchase Requests</p>
                            <h3 class="mb-0 font-weight-bolder">{{ $stats['total_pr'] }}</h3>
                        </div>
                        <div class="icon bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-file-invoice-dollar fa-fw"></i>
                        </div>
                    </div>
                    <a href="{{ route('purchase-requests.index') }}" class="small-box-footer mt-3 d-block text-sm text-white opacity-75 hover-opacity-100">View All <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card bg-warning p-3 mb-4 rounded-lg shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-xs font-weight-bold mb-1 opacity-75">Pending Approval</p>
                            <h3 class="mb-0 font-weight-bolder">{{ $stats['pending_pr'] }}</h3>
                        </div>
                        <div class="icon bg-dark bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-clock fa-fw"></i>
                        </div>
                    </div>
                    <a href="{{ route('purchase-requests.index', ['status' => 'pending']) }}" class="small-box-footer mt-3 d-block text-sm opacity-75 hover-opacity-100">Review Now <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card bg-success p-3 mb-4 rounded-lg shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-xs font-weight-bold mb-1 opacity-75">Total Users</p>
                            <h3 class="mb-0 font-weight-bolder">{{ $stats['total_users'] }}</h3>
                        </div>
                        <div class="icon bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-users fa-fw"></i>
                        </div>
                    </div>
                    <a href="{{ route('users.index') }}" class="small-box-footer mt-3 d-block text-sm text-white opacity-75 hover-opacity-100">Manage Users <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card bg-secondary p-3 mb-4 rounded-lg shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-xs font-weight-bold mb-1 opacity-75">Departments</p>
                            <h3 class="mb-0 font-weight-bolder">{{ $stats['total_departments'] }}</h3>
                        </div>
                        <div class="icon bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-building fa-fw"></i>
                        </div>
                    </div>
                    <a href="{{ route('departments.index') }}" class="small-box-footer mt-3 d-block text-sm text-white opacity-75 hover-opacity-100">Manage Depts <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>

        @elseif(Auth::user()->hasRole('user'))
             <div class="col-lg-3 col-6">
                <div class="card bg-info p-3 mb-4 rounded-lg shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-xs font-weight-bold mb-1 opacity-75">My Requests</p>
                            <h3 class="mb-0 font-weight-bolder">{{ $stats['my_pr'] }}</h3>
                        </div>
                        <div class="icon bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-file-alt fa-fw"></i>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-lg-3 col-6">
                <div class="card bg-warning p-3 mb-4 rounded-lg shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-xs font-weight-bold mb-1 opacity-75">Pending</p>
                            <h3 class="mb-0 font-weight-bolder">{{ $stats['pending_pr'] }}</h3>
                        </div>
                        <div class="icon bg-dark bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-hourglass-half fa-fw"></i>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-lg-3 col-6">
                <div class="card bg-success p-3 mb-4 rounded-lg shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-xs font-weight-bold mb-1 opacity-75">Approved</p>
                            <h3 class="mb-0 font-weight-bolder">{{ $stats['approved_pr'] }}</h3>
                        </div>
                        <div class="icon bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-check-circle fa-fw"></i>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-lg-3 col-6">
                <div class="card bg-danger p-3 mb-4 rounded-lg shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-xs font-weight-bold mb-1 opacity-75">Rejected</p>
                            <h3 class="mb-0 font-weight-bolder">{{ $stats['rejected_pr'] }}</h3>
                        </div>
                        <div class="icon bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-times-circle fa-fw"></i>
                        </div>
                    </div>
                </div>
            </div>

        @else
             <!-- Managers -->
             <div class="col-lg-3 col-6">
                <div class="card bg-primary p-3 mb-4 rounded-lg shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-xs font-weight-bold mb-1 opacity-75">PR to Review</p>
                            <h3 class="mb-0 font-weight-bolder">{{ $stats['pr_to_review'] }}</h3>
                        </div>
                        <div class="icon bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-clipboard-check fa-fw"></i>
                        </div>
                    </div>
                    <a href="{{ route('purchase-requests.index', ['status' => 'pending']) }}" class="small-box-footer mt-3 d-block text-sm text-white opacity-75 hover-opacity-100">Review Now <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
             <div class="col-lg-3 col-6">
                <div class="card bg-info p-3 mb-4 rounded-lg shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-xs font-weight-bold mb-1 opacity-75">Total PR in System</p>
                            <h3 class="mb-0 font-weight-bolder">{{ $stats['total_pr'] }}</h3>
                        </div>
                        <div class="icon bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-list fa-fw"></i>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-lg-3 col-6">
                <div class="card bg-success p-3 mb-4 rounded-lg shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-xs font-weight-bold mb-1 opacity-75">Approved Today</p>
                            <h3 class="mb-0 font-weight-bolder">{{ $stats['approved_today'] }}</h3>
                        </div>
                        <div class="icon bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-calendar-check fa-fw"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Charts Row -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Status Distribution</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Monthly PR Trends</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="trendChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Purchase Requests</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                       <table class="table table-hover table-borderless text-sm">
                            <thead>
                                <tr>
                                    <th>PR Number</th>
                                    <th>Date</th>
                                    <th>Requester</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPRs as $pr)
                                <tr>
                                    <td>{{ $pr->pr_number ?? 'Pending' }}</td>
                                    <td>{{ $pr->created_at->format('d M Y') }}</td>
                                    <td>{{ $pr->user->name }}</td>
                                    <td>{{ $pr->department->code }}</td>
                                    <td>
                                        @php
                                            $statusLabel = $pr->approval_status;
                                            $badgeClass = match($statusLabel) {
                                                'Draft' => 'badge-secondary',
                                                'Pending' => 'badge-warning',
                                                'Revision Required' => 'badge-danger',
                                                'Partial / Revision' => 'badge-warning',
                                                'Processing' => 'badge-info',
                                                'Approved (OM)', 'Approved (GM)', 'Approved (Proc)' => 'badge-info',
                                                'Ordered' => 'badge-primary',
                                                'Delivered' => 'badge-teal',
                                                'Completed' => 'badge-success',
                                                default => 'badge-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('purchase-requests.show', $pr) }}" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No recent records found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Status Distribution Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($chartData['status_distribution']['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($chartData['status_distribution']['data']) !!},
                        backgroundColor: ['#6c757d', '#ffc107', '#dc3545', '#17a2b8', '#28a745'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#a0aec0' 
                            }
                        }
                    }
                }
            });

            // Monthly Trend Chart
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartData['monthly_trends']['labels']) !!},
                    datasets: [{
                        label: 'Purchase Requests',
                        data: {!! json_encode($chartData['monthly_trends']['data']) !!},
                        borderColor: '#2563eb', // Blue Primary
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#2563eb',
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#a0aec0'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                stepSize: 1,
                                color: '#a0aec0'
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#a0aec0'
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
