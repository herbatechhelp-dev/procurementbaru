<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-weight-bold tracking-tight mb-0">
                {{ __('Overview') }}
            </h2>
            <div class="d-none d-md-block text-muted text-sm">
                <i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::now()->format('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <style>
        .stat-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.3) !important;
        }
        .stat-icon-wrapper {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }
        .stat-card:hover .stat-icon-wrapper {
            transform: scale(1.1);
        }
        .border-primary-accent { border-left: 4px solid #3b82f6 !important; }
        .text-primary-accent { color: #3b82f6 !important; }
        .bg-primary-soft { background-color: rgba(59, 130, 246, 0.15) !important; }

        .border-warning-accent { border-left: 4px solid #f59e0b !important; }
        .text-warning-accent { color: #f59e0b !important; }
        .bg-warning-soft { background-color: rgba(245, 158, 11, 0.15) !important; }

        .border-success-accent { border-left: 4px solid #10b981 !important; }
        .text-success-accent { color: #10b981 !important; }
        .bg-success-soft { background-color: rgba(16, 185, 129, 0.15) !important; }

        .border-danger-accent { border-left: 4px solid #ef4444 !important; }
        .text-danger-accent { color: #ef4444 !important; }
        .bg-danger-soft { background-color: rgba(239, 68, 68, 0.15) !important; }

        .border-info-accent { border-left: 4px solid #06b6d4 !important; }
        .text-info-accent { color: #06b6d4 !important; }
        .bg-info-soft { background-color: rgba(6, 182, 212, 0.15) !important; }
        
        .border-purple-accent { border-left: 4px solid #8b5cf6 !important; }
        .text-purple-accent { color: #8b5cf6 !important; }
        .bg-purple-soft { background-color: rgba(139, 92, 246, 0.15) !important; }
        
        .tracking-wider { letter-spacing: 0.05em; }
    </style>

    <!-- Small boxes (Stat box) -->
    <div class="row">
        @if(Auth::user()->hasRole('superadmin'))
            <div class="col-lg-3 col-sm-6">
                <div class="card stat-card border-0 shadow-sm border-primary-accent mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-uppercase text-xs font-weight-bold mb-1 text-muted tracking-wider">Total PR</p>
                                <h3 class="mb-0 font-weight-bolder text-white">{{ $stats['total_pr'] }}</h3>
                            </div>
                            <div class="stat-icon-wrapper rounded-circle d-flex align-items-center justify-content-center bg-primary-soft">
                                <i class="fas fa-file-invoice-dollar text-primary-accent" style="font-size: 1.3rem;"></i>
                            </div>
                        </div>
                        <a href="{{ route('purchase-requests.index') }}" class="text-sm font-weight-medium text-primary-accent mt-3 d-inline-block" style="text-decoration: none;">View All <i class="fas fa-arrow-right ml-1 text-xs"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-sm-6">
                <div class="card stat-card border-0 shadow-sm border-warning-accent mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-uppercase text-xs font-weight-bold mb-1 text-muted tracking-wider">Pending</p>
                                <h3 class="mb-0 font-weight-bolder text-white">{{ $stats['pending_pr'] }}</h3>
                            </div>
                            <div class="stat-icon-wrapper rounded-circle d-flex align-items-center justify-content-center bg-warning-soft">
                                <i class="fas fa-clock text-warning-accent" style="font-size: 1.3rem;"></i>
                            </div>
                        </div>
                        <a href="{{ route('purchase-requests.index', ['status' => 'pending']) }}" class="text-sm font-weight-medium text-warning-accent mt-3 d-inline-block" style="text-decoration: none;">Review Now <i class="fas fa-arrow-right ml-1 text-xs"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-sm-6">
                <div class="card stat-card border-0 shadow-sm border-success-accent mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-uppercase text-xs font-weight-bold mb-1 text-muted tracking-wider">Total Users</p>
                                <h3 class="mb-0 font-weight-bolder text-white">{{ $stats['total_users'] }}</h3>
                            </div>
                            <div class="stat-icon-wrapper rounded-circle d-flex align-items-center justify-content-center bg-success-soft">
                                <i class="fas fa-users text-success-accent" style="font-size: 1.3rem;"></i>
                            </div>
                        </div>
                        <a href="{{ route('users.index') }}" class="text-sm font-weight-medium text-success-accent mt-3 d-inline-block" style="text-decoration: none;">Manage Users <i class="fas fa-arrow-right ml-1 text-xs"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-sm-6">
                <div class="card stat-card border-0 shadow-sm border-purple-accent mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-uppercase text-xs font-weight-bold mb-1 text-muted tracking-wider">Departments</p>
                                <h3 class="mb-0 font-weight-bolder text-white">{{ $stats['total_departments'] }}</h3>
                            </div>
                            <div class="stat-icon-wrapper rounded-circle d-flex align-items-center justify-content-center bg-purple-soft">
                                <i class="fas fa-building text-purple-accent" style="font-size: 1.3rem;"></i>
                            </div>
                        </div>
                        <a href="{{ route('departments.index') }}" class="text-sm font-weight-medium text-purple-accent mt-3 d-inline-block" style="text-decoration: none;">Manage Depts <i class="fas fa-arrow-right ml-1 text-xs"></i></a>
                    </div>
                </div>
            </div>

        @elseif(Auth::user()->hasRole('user'))
             <div class="col-lg-3 col-sm-6">
                <div class="card stat-card border-0 shadow-sm border-primary-accent mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-uppercase text-xs font-weight-bold mb-1 text-muted tracking-wider">My Requests</p>
                                <h3 class="mb-0 font-weight-bolder text-white">{{ $stats['my_pr'] }}</h3>
                            </div>
                            <div class="stat-icon-wrapper rounded-circle d-flex align-items-center justify-content-center bg-primary-soft">
                                <i class="fas fa-file-alt text-primary-accent" style="font-size: 1.3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
             <div class="col-lg-3 col-sm-6">
                <div class="card stat-card border-0 shadow-sm border-warning-accent mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-uppercase text-xs font-weight-bold mb-1 text-muted tracking-wider">Pending</p>
                                <h3 class="mb-0 font-weight-bolder text-white">{{ $stats['pending_pr'] }}</h3>
                            </div>
                            <div class="stat-icon-wrapper rounded-circle d-flex align-items-center justify-content-center bg-warning-soft">
                                <i class="fas fa-hourglass-half text-warning-accent" style="font-size: 1.3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
             <div class="col-lg-3 col-sm-6">
                <div class="card stat-card border-0 shadow-sm border-success-accent mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-uppercase text-xs font-weight-bold mb-1 text-muted tracking-wider">Approved</p>
                                <h3 class="mb-0 font-weight-bolder text-white">{{ $stats['approved_pr'] }}</h3>
                            </div>
                            <div class="stat-icon-wrapper rounded-circle d-flex align-items-center justify-content-center bg-success-soft">
                                <i class="fas fa-check-circle text-success-accent" style="font-size: 1.3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
             <div class="col-lg-3 col-sm-6">
                <div class="card stat-card border-0 shadow-sm border-danger-accent mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-uppercase text-xs font-weight-bold mb-1 text-muted tracking-wider">Rejected</p>
                                <h3 class="mb-0 font-weight-bolder text-white">{{ $stats['rejected_pr'] }}</h3>
                            </div>
                            <div class="stat-icon-wrapper rounded-circle d-flex align-items-center justify-content-center bg-danger-soft">
                                <i class="fas fa-times-circle text-danger-accent" style="font-size: 1.3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
        @else
             <!-- Managers / Procurement -->
             <div class="col-lg-4 col-md-4 mb-4">
                <div class="card stat-card border-0 shadow-sm border-warning-accent h-100">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-uppercase text-xs font-weight-bold mb-1 text-muted tracking-wider">PR to Review</p>
                                <h3 class="mb-0 font-weight-bolder text-white">{{ $stats['pr_to_review'] }}</h3>
                            </div>
                            <div class="stat-icon-wrapper rounded-circle d-flex align-items-center justify-content-center bg-warning-soft">
                                <i class="fas fa-clipboard-check text-warning-accent" style="font-size: 1.3rem;"></i>
                            </div>
                        </div>
                        <a href="{{ route('purchase-requests.approvals') }}" class="text-sm font-weight-medium text-warning-accent mt-3 d-inline-block" style="text-decoration: none;">Review Now <i class="fas fa-arrow-right ml-1 text-xs"></i></a>
                    </div>
                </div>
            </div>
            
             <div class="col-lg-4 col-md-4 mb-4">
                <div class="card stat-card border-0 shadow-sm border-primary-accent h-100">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-uppercase text-xs font-weight-bold mb-1 text-muted tracking-wider">Total PR in System</p>
                                <h3 class="mb-0 font-weight-bolder text-white">{{ $stats['total_pr'] }}</h3>
                            </div>
                            <div class="stat-icon-wrapper rounded-circle d-flex align-items-center justify-content-center bg-primary-soft">
                                <i class="fas fa-list text-primary-accent" style="font-size: 1.3rem;"></i>
                            </div>
                        </div>
                        <a href="{{ route('purchase-requests.index') }}" class="text-sm font-weight-medium text-primary-accent mt-3 d-inline-block" style="text-decoration: none;">View All <i class="fas fa-arrow-right ml-1 text-xs"></i></a>
                    </div>
                </div>
            </div>
            
             <div class="col-lg-4 col-md-4 mb-4">
                <div class="card stat-card border-0 shadow-sm border-success-accent h-100">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-uppercase text-xs font-weight-bold mb-1 text-muted tracking-wider">Approved Today</p>
                                <h3 class="mb-0 font-weight-bolder text-white">{{ $stats['approved_today'] }}</h3>
                            </div>
                            <div class="stat-icon-wrapper rounded-circle d-flex align-items-center justify-content-center bg-success-soft">
                                <i class="fas fa-calendar-check text-success-accent" style="font-size: 1.3rem;"></i>
                            </div>
                        </div>
                        <div class="mt-3 text-sm d-inline-block" style="opacity: 0; pointer-events: none;">&nbsp;</div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-xl-5 col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 bg-transparent py-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold tracking-tight">Status Distribution</h5>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 260px; width: 100%;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7 col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 bg-transparent py-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold tracking-tight">Monthly PR Trends</h5>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 260px; width: 100%;">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0 bg-transparent py-4 pb-2">
                    <h5 class="mb-0 font-weight-bold tracking-tight">Recent Purchase Requests</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                       <table class="table table-hover table-borderless text-sm mb-0">
                            <thead>
                                <tr>
                                    <th class="pl-4">PR Number</th>
                                    <th>Date</th>
                                    <th>Requester</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th class="pr-4 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPRs as $pr)
                                <tr>
                                    <td class="pl-4 font-weight-medium text-white">{{ $pr->pr_number ?? 'Pending' }}</td>
                                    <td class="text-muted">{{ $pr->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary-soft text-primary-accent rounded-circle d-flex align-items-center justify-content-center mr-2" style="width: 28px; height: 28px; font-weight: 600; font-size: 0.75rem;">
                                                {{ substr($pr->user->name, 0, 1) }}
                                            </div>
                                            {{ $pr->user->name }}
                                        </div>
                                    </td>
                                    <td>{{ $pr->department->code }}</td>
                                    <td>
                                        @php
                                            $statusLabel = $pr->approval_status;
                                            $badgeClass = match($statusLabel) {
                                                'Draft' => 'badge-secondary',
                                                'Pending' => 'badge-warning',
                                                'Revision Required' => 'badge-danger',
                                                'Partial / Revision' => 'badge-warning',
                                                'Processing' => 'bg-primary-soft text-primary-accent border border-primary-accent',
                                                'Approved (OM)' => 'bg-info-soft text-info-accent border border-info-accent',
                                                'Approved (GM)' => 'bg-info-soft text-info-accent border border-info-accent',
                                                'Approved (Proc)' => 'bg-info-soft text-info-accent border border-info-accent',
                                                'Ordered' => 'bg-purple-soft text-purple-accent border border-purple-accent',
                                                'Delivered' => 'bg-success-soft text-success-accent',
                                                'Completed' => 'badge-success',
                                                default => 'badge-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}" style="{{ str_contains($badgeClass, 'border') ? 'border-width: 1px !important;' : '' }}">{{ $statusLabel }}</span>
                                    </td>
                                    <td class="pr-4 text-center">
                                        <a href="{{ route('purchase-requests.show', $pr) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 6px; padding: 0.25rem 0.75rem;">Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="far fa-folder-open mb-3" style="font-size: 2.5rem; opacity: 0.5;"></i>
                                        <p class="mb-0 font-weight-medium">No recent records found.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($recentPRs) > 0)
                <div class="card-footer bg-transparent border-0 text-center py-3">
                    <a href="{{ route('purchase-requests.index') }}" class="text-sm font-weight-medium text-primary-accent" style="text-decoration: none;">View Full List <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart Defaults for Modern Dark Mode
            Chart.defaults.color = '#94a3b8';
            Chart.defaults.font.family = "'Inter', sans-serif";
            
            // Status Distribution Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($chartData['status_distribution']['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($chartData['status_distribution']['data']) !!},
                        backgroundColor: ['#64748b', '#f59e0b', '#ef4444', '#06b6d4', '#10b981'],
                        borderWidth: 2,
                        borderColor: '#1e293b', // Match card background
                        hoverOffset: 4
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleColor: '#f1f5f9',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(255,255,255,0.1)',
                            borderWidth: 1,
                            padding: 12,
                            boxPadding: 6,
                            usePointStyle: true,
                        }
                    }
                }
            });

            // var gradient = trendCtx.createLinearGradient(0, 0, 0, 400); ...
            // Wait we need canvas reference before creating gradient
            const trendCanvas = document.getElementById('trendChart');
            const trendCtx = trendCanvas.getContext('2d');
            
            var gradient = trendCtx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');   
            gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

            // Monthly Trend Chart
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartData['monthly_trends']['labels']) !!},
                    datasets: [{
                        label: 'Purchase Requests',
                        data: {!! json_encode($chartData['monthly_trends']['data']) !!},
                        borderColor: '#3b82f6', // Tailwind Blue 500
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4, // Smooth curve
                        pointBackgroundColor: '#1e293b',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#3b82f6',
                        pointHoverBorderColor: '#ffffff',
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: false // Hide legend for single line
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleColor: '#f1f5f9',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(255,255,255,0.1)',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Requests';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.03)',
                                drawBorder: false
                            },
                            border: { display: false },
                            ticks: {
                                stepSize: 1,
                                padding: 10
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            border: { display: false },
                            ticks: {
                                padding: 10
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
