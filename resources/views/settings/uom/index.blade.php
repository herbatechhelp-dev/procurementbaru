<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('UOM Management') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Units of Measure</h3>
                    <div class="card-tools">
                        <a href="{{ route('uoms.create') }}" class="btn btn-sm btn-primary text-black">
                            <i class="fas fa-plus"></i> Add UOM
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th style="width: 150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($uoms as $uom)
                            <tr>
                                <td>{{ ($uoms->currentPage() - 1) * $uoms->perPage() + $loop->iteration }}</td>
                                <td>{{ $uom->name }}</td>
                                <td>{{ $uom->description }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('uoms.edit', $uom) }}" class="btn btn-sm btn-info">Edit</a>
                                        <form action="{{ route('uoms.destroy', $uom) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this UOM?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger ml-1">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No UOM found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $uoms->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
