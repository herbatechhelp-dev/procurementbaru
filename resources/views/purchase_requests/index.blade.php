<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $title ?? __('Purchase Requests') }}
            </h2>
            @can('create pr')
            @if(empty($hideCreateButton))
            <a href="{{ route('purchase-requests.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Create new PR
            </a>
            @endif
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow-sm rounded-lg">
                <div class="card-body p-4">


                    @if(!isset($title) || !str_contains(strtolower($title), 'needs revision'))
                        @if(auth()->user()->hasAnyRole(['procurement', 'superadmin']))
                        <!-- Department Tabs -->
                        <div class="mb-4">
                            <ul class="nav nav-pills p-1 rounded-lg" style="background-color: rgba(255,255,255,0.05);">
                                <li class="nav-item">
                                    <a class="nav-link {{ !request('department_id') ? 'active bg-primary' : 'text-muted' }} small py-1 px-3" href="{{ request()->fullUrlWithQuery(['department_id' => null]) }}">
                                        All Departments
                                    </a>
                                </li>
                                @foreach($departments as $dept)
                                <li class="nav-item">
                                    <a class="nav-link {{ request('department_id') == $dept->id ? 'active bg-primary' : 'text-muted' }} small py-1 px-3" href="{{ request()->fullUrlWithQuery(['department_id' => $dept->id]) }}">
                                        {{ $dept->code }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Filter Form -->
                        <div class="card mb-4 shadow-sm" style="background-color: rgba(255,255,255,0.02)">
                            <div class="card-body py-3">
                                <form action="{{ request()->url() }}" method="GET" class="row align-items-end mb-0">
                                    @if(request('department_id'))
                                        <input type="hidden" name="department_id" value="{{ request('department_id') }}">
                                    @endif
                                    
                                    <div class="col-md-5 mb-2">
                                        <label for="search" class="form-label font-weight-bold small text-uppercase opacity-75">Search</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0 text-muted">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="search" id="search" class="form-control border-left-0" placeholder="PR Number, Purpose, Requester..." value="{{ request('search') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label for="status" class="form-label font-weight-bold small text-uppercase opacity-75">Status</label>
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
                            <div class="card mb-4 shadow-sm" style="background-color: rgba(255,255,255,0.02)">
                                <div class="card-body py-2">
                                    <form action="{{ request()->url() }}" method="GET" class="row align-items-end mb-0">
                                        <div class="col-md-10 mb-2">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent border-right-0 text-muted">
                                                        <i class="fas fa-search"></i>
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
                        <table class="table table-hover table-borderless text-sm">
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
                                            $totalItems = $pr->items->count();
                                            $approvedItems = $pr->items->filter(function ($item) {
                                                return in_array($item->status, ['approved_om', 'approved_gm', 'approved_proc', 'ordered', 'delivered', 'completed']);
                                            })->count();

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

                                            $progressClass = 'badge-secondary';
                                            if ($totalItems > 0 && $approvedItems === $totalItems) {
                                                $progressClass = 'badge-success';
                                            } elseif ($approvedItems > 0) {
                                                $progressClass = 'badge-info';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                        @if($totalItems > 0)
                                            <div class="mt-1">
                                                <span class="badge {{ $progressClass }}">{{ $approvedItems }}/{{ $totalItems }} approved</span>
                                            </div>
                                        @endif
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
                                        <form action="{{ route('purchase-requests.destroy', $pr) }}" method="POST" class="d-inline form-confirm" data-message="Delete this PR?">
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
