<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hi.. <b>{{ Auth::user()->name }}</b>
            
            <b style="float: right;">Total categories: 
                <span class="badge bg-primary">{{ $categories->total() }}</span>
            </b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        @endif
                        <div class="card-header">All Category        
                        </div>
                    
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Serial #</th>
                                <th scope="col">Name</th>
                                <th scope="col">User</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <th scope="row">{{ $category->id }}</th>
                                    <td>{{ $category->category_name }}</td>
                                    <td>{{ $category->user->name }}</td>
                                    <td>{{ $category->created_at->diffForHumans() }}</td>
                                    <td>
                                        <form action="{{ route('destroy.category', ['id' => $category->id] ) }}" method="POST">
                                            <a href="{{ route('edit.category', ['id' => $category->id]) }}" 
                                                class="btn btn-info">Edit</a>
                                            
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $categories->links() }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Add Category</div>
                        <div class="card-body">
                            <form action="{{ route('store.category') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="category_name" id="category_name">

                                    @error('category_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>          
        </div>

        {{-- Trashed list --}}
        <div class="py-12">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card-header">Trashed Category        
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Serial #</th>
                                <th scope="col">Name</th>
                                <th scope="col">User</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($trashed as $category)
                                <tr>
                                    <th scope="row">{{ $category->id }}</th>
                                    <td>{{ $category->category_name }}</td>
                                    <td>{{ $category->user->name }}</td>
                                    <td>{{ $category->created_at->diffForHumans() }}</td>
                                    <td>
                                        <form action="{{ route('restore.category', ['id' => $category->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-info">Restore</button>
                                            <a href="{{ route('forceDelete.category', ['id' => $category->id]) }}" class="btn btn-danger">Force Delete</a>
                                        </form>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $trashed->links() }}
                    </div>

                    <div class="col-md-4">
                        
                    </div>
                </div>          
            </div>
    
    </div>
</x-app-layout>
