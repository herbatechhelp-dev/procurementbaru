<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Departments') }}
            </h2>
            @can('create departments')
            <a href="{{ route('departments.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Department
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow-sm rounded-lg">
                <div class="card-body p-4">


                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Manager</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departments as $dept)
                                <tr>
                                    <td>{{ $dept->id }}</td>
                                    <td>{{ $dept->code }}</td>
                                    <td>{{ $dept->name }}</td>
                                    <td>{{ $dept->manager ?? '-' }}</td>
                                    <td>
                                        @if($dept->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('edit departments')
                                        <a href="{{ route('departments.edit', $dept) }}" class="btn btn-warning btn-xs">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        
                                        @can('delete departments')
                                        <form action="{{ route('departments.destroy', $dept) }}" method="POST" class="d-inline form-confirm" data-message="Are you sure? This might affect associated users and PRs.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $departments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
