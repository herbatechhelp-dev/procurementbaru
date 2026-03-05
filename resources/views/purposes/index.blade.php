<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Purpose Management') }}
            </h2>
            <a href="{{ route('purposes.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Purpose
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow-sm rounded-lg">
                <div class="card-body p-4">


                    <form method="GET" action="{{ route('purposes.index') }}" class="row mb-3">
                        <div class="col-md-10 mb-2 mb-md-0">
                            <input type="text" name="search" class="form-control" placeholder="Search purpose name..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purposes as $purpose)
                                <tr>
                                    <td>{{ $purpose->id }}</td>
                                    <td>{{ $purpose->name }}</td>
                                    <td>{{ $purpose->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('purposes.edit', $purpose) }}" class="btn btn-warning btn-xs">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('purposes.destroy', $purpose) }}" method="POST" class="d-inline form-confirm" data-message="Are you sure?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No purpose found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $purposes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
