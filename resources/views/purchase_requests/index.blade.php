<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $title ?? __('Purchase Requests') }}
            </h2>
            @can('create pr')
            <a href="{{ route('purchase-requests.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Create new PR
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if(!isset($title) || !str_contains(strtolower($title), 'needs revision'))
                        @if(auth()->user()->hasAnyRole(['operational_manager', 'general_manager', 'procurement', 'superadmin']))
                        <!-- Department Tabs -->
                        <div class="mb-4">
                            <ul class="nav nav-pills bg-light p-1 rounded-lg">
                                <li class="nav-item">
                                    <a class="nav-link {{ !request('department_id') ? 'active' : '' }} small py-1 px-3" href="{{ request()->fullUrlWithQuery(['department_id' => null]) }}">
                                        All Departments
                                    </a>
                                </li>
                                @foreach($departments as $dept)
                                <li class="nav-item">
                                    <a class="nav-link {{ request('department_id') == $dept->id ? 'active' : '' }} small py-1 px-3" href="{{ request()->fullUrlWithQuery(['department_id' => $dept->id]) }}">
                                        {{ $dept->code }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Filter Form -->
                        <div class="card bg-white mb-4 shadow-sm border">
                            <div class="card-body py-3">
                                <form action="{{ request()->url() }}" method="GET" class="row align-items-end mb-0">
                                    @if(request('department_id'))
                                        <input type="hidden" name="department_id" value="{{ request('department_id') }}">
                                    @endif
                                    
                                    <div class="col-md-5 mb-2">
                                        <label for="search" class="form-label font-weight-bold small text-uppercase">Search</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white border-right-0">
                                                    <i class="fas fa-search text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="search" id="search" class="form-control border-left-0" placeholder="PR Number, Purpose, Requester, or Item Name..." value="{{ request('search') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label for="status" class="form-label font-weight-bold small text-uppercase">Status</label>
                                        <select name="status" id="status" class="form-control form-control-sm">
                                            <option value="">All Status</option>
                                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                                            <option value="approved_om" {{ request('status') == 'approved_om' ? 'selected' : '' }}>Approved (OM)</option>
                                            <option value="rejected_om" {{ request('status') == 'rejected_om' ? 'selected' : '' }}>Rejected (OM)</option>
                                            <option value="approved_gm" {{ request('status') == 'approved_gm' ? 'selected' : '' }}>Approved (GM)</option>
                                            <option value="rejected_gm" {{ request('status') == 'rejected_gm' ? 'selected' : '' }}>Rejected (GM)</option>
                                            <option value="approved_proc" {{ request('status') == 'approved_proc' ? 'selected' : '' }}>Approved (Proc)</option>
                                            <option value="rejected_proc" {{ request('status') == 'rejected_proc' ? 'selected' : '' }}>Rejected (Proc)</option>
                                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-2 d-flex gap-2">
                                        <a href="{{ request()->fullUrlWithQuery(['awaiting_approval' => request('awaiting_approval') ? null : 1]) }}" 
                                           class="btn btn-sm w-100 {{ request('awaiting_approval') ? 'btn-warning' : 'btn-outline-warning' }}" 
                                           title="Show PRs waiting for my approval">
                                            <i class="fas fa-clock mr-1"></i> Awaiting Me
                                        </a>
                                        
                                        <div class="btn-group btn-group-sm w-100">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="{{ request()->url() }}" class="btn btn-secondary" title="Reset Filters">
                                                <i class="fas fa-undo"></i>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @else
                            <!-- Simple Search for Regular User -->
                            <div class="card bg-white mb-4 shadow-sm border">
                                <div class="card-body py-2">
                                    <form action="{{ request()->url() }}" method="GET" class="row align-items-end mb-0">
                                        <div class="col-md-10 mb-2">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white border-right-0">
                                                        <i class="fas fa-search text-muted"></i>
                                                    </span>
                                                </div>
                                                <input type="text" name="search" id="search" class="form-control border-left-0" placeholder="Cari PR Number, Tujuan, atau Nama Item..." value="{{ request('search') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block">Cari</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endif



                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>PR Number</th>
                                    <th>Date</th>
                                    <th>Requester</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchaseRequests as $pr)
                                <tr>
                                    <td>{{ $pr->pr_number }}</td>
                                    <td>{{ $pr->request_date->format('d M Y') }}</td>
                                    <td>{{ $pr->user->name }}</td>
                                    <td>{{ $pr->department->code }}</td>
                                    <td>
                                        @php
                                            $status = $pr->approval_status;
                                            $badgeClass = match($status) {
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
                                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                    </td>
                                    </td>
                                    <td>
                                        <a href="{{ route('purchase-requests.show', $pr) }}" class="btn btn-info btn-xs">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($pr->isEditable() && auth()->id() == $pr->user_id)
                                        <a href="{{ route('purchase-requests.edit', $pr) }}" class="btn btn-warning btn-xs" title="Edit/Revise">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endif

                                        @if(auth()->id() == $pr->user_id && $pr->isDeletable())
                                        <form action="{{ route('purchase-requests.destroy', $pr) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this PR?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No Purchase Requests found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $purchaseRequests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
