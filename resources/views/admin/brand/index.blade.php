<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hi.. <b>{{ Auth::user()->name }}</b>
            
            <b style="float: right;">Total brands: 
                <span class="badge bg-primary">{{ $brands->total() }}</span>
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
                        <div class="card-header">All Brands        
                        </div>
                    
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Serial #</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Created by</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                    <th scope="row">{{ $brand->id }}</th>
                                    <td>{{ $brand->brand_name }}</td>
                                    <td><img src="{{ URL::asset($brand->image) }}" style="height:40px; width:70px"></td>
                                    <td>{{ $brand->user->name }}</td>
                                    <td>{{ $brand->created_at->diffForHumans() }}</td>
                                    <td>
                                        <form action="{{ route('destroy.brand', ['id' => $brand->id] ) }}" method="POST">
                                            <a href="{{ route('edit.brand', ['id' => $brand->id]) }}" 
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
                        {{ $brands->links() }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Add Brand</div>
                        <div class="card-body">
                            <form action="{{ route('store.brand') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="mb-3">
                                    <label for="brand_name" class="form-label">Brand Name</label>
                                    <input type="text" class="form-control" name="brand_name" id="brand_name" value="{{ old('brand_name') }}">

                                    @error('brand_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Brand Image</label>
                                    <input type="file" class="form-control" name="image" id="image">

                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add Brand</button>
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
                        <div class="card-header">Trashed Brands        
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Serial #</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">User</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($trashed as $brand)
                                <tr>
                                    <th scope="row">{{ $brand->id }}</th>
                                    <td>{{ $brand->brand_name }}</td>
                                    <td><img src="{{ URL::asset($brand->image) }}" style="height:40px; width:70px"></td>
                                    <td>{{ $brand->user->name }}</td>
                                    <td>{{ $brand->created_at->diffForHumans() }}</td>
                                    <td>
                                        <form action="{{ route('restore.brand', ['id' => $brand->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-info">Restore</button>
                                            <a href="{{ route('forceDelete.brand', ['id' => $brand->id]) }}" class="btn btn-danger">Force Delete</a>
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
