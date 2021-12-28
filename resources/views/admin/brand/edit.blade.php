<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Brand
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Edit Brand</div>
                        <div class="card-body">
                            <form action="{{ route('update.brand', ['id' => $brand->id]) }}" method="POST" 
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="old_image" value="{{ $brand->image }}">
                                <div class="mb-3">
                                    <label for="brand_name" class="form-label">Update Brand Name</label>
                                    <input type="text" class="form-control" name="brand_name" 
                                        id="brand_name" value="{{ $brand->brand_name }}">

                                    @error('brand_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Brand Image</label>
                                    <input type="file" class="form-control" name="image" 
                                        id="image">

                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <img src="{{ URL::asset($brand->image) }}" style="height:80px; width:140px">
                                </div>

                                <button type="submit" class="btn btn-primary">Update Brand</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>          
        </div>
    </div>
</x-app-layout>
