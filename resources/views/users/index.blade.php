<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Management') }}
            </h2>
            @can('create users')
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New User
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Employee ID</th>
                                    <th>Department</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->employee_id }}</td>
                                    <td>{{ $user->department->name ?? '-' }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="badge badge-info">{{ ucfirst($role->name) }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span class="badge badge-success">Active</span>
                                    </td>
                                    <td>
                                        @can('edit users')
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-xs">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        
                                        @can('delete users')
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline form-confirm" data-message="Are you sure?">
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
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
