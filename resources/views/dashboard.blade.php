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
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $stats['total_pr'] }}</h3>
                        <p>Total Purchase Requests</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <a href="{{ route('purchase-requests.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
               <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $stats['pending_pr'] }}</h3>
                        <p>Pending Approval</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <a href="{{ route('purchase-requests.index', ['status' => 'pending']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $stats['total_users'] }}</h3>
                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $stats['total_departments'] }}</h3>
                        <p>Departments</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="{{ route('departments.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        @elseif(Auth::user()->hasRole('user'))
             <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $stats['my_pr'] }}</h3>
                        <p>My Requests</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
             <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $stats['pending_pr'] }}</h3>
                        <p>Pending</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
            </div>
             <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $stats['approved_pr'] }}</h3>
                        <p>Approved</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
             <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $stats['rejected_pr'] }}</h3>
                        <p>Rejected</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>

        @else
             <!-- Managers -->
             <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $stats['pr_to_review'] }}</h3>
                        <p>PR to Review</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <a href="{{ route('purchase-requests.index', ['status' => 'pending']) }}" class="small-box-footer">Review Now <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
             <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $stats['total_pr'] }}</h3>
                        <p>Total PR in System</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-list"></i>
                    </div>
                </div>
            </div>
             <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $stats['approved_today'] }}</h3>
                        <p>Approved Today</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-check"></i>
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
                       <table class="table table-bordered table-striped">
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
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        position: 'bottom'
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
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
