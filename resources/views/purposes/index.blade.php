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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purposes as $purpose)
                                <tr>
                                    <td>{{ $purpose->id }}</td>
                                    <td>{{ $purpose->name }}</td>
                                    <td>{{ $purpose->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('purposes.edit', $purpose) }}" class="btn btn-warning btn-xs">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('purposes.destroy', $purpose) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
