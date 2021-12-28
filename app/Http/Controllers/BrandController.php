<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index() {
        $brands = Brand::paginate(5);
        $trashedBrands = Brand::onlyTrashed()->paginate(3);
        return view('admin.brand.index', ['brands' => $brands, 'trashed' => $trashedBrands]);  
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|max:255|min:4',
            'image' => 'required|mimes:jpg,jpeg,png'
        ],
        [
            'image.mimes' => 'Allowed file types are jpg, jpeg, and png.'
        ]);

        $brand_image = $request->file('image');
        $unique_name = hexdec(uniqid());
        $extension = strtolower($brand_image->getClientOriginalExtension());

        $filename = $unique_name . '.' . $extension;

        $upLocation = 'image/brand/';
        $lastImage = $upLocation . $filename;

        $brand_image->move($upLocation, $filename);
        

        Brand::insert([
            'brand_name' => $request->brand_name,
            'user_id' => Auth::user()->id,
            'image' => $lastImage,
            'created_at' => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'Brand inserted successfully');
    }

    public function edit($id) {
        $brand = Brand::findOrFail($id);

        return view('admin.brand.edit', ['brand' => $brand]);
    }

    public function update(Request $request, $id) {

        $validated = $request->validate([
            'brand_name' => 'required|max:255',
            'image' => 'mimes:jpg,jpeg,png'
        ],
        [
            'image.mimes' => 'Allowed file types are jpg, jpeg, and png.'
        ]);

        $brand = Brand::findOrFail($id);

        $oldImage = $request->old_image;
        $brand_image = $request->file('image');

        if($brand_image) {
            if (File::exists($oldImage)) {
                unlink($oldImage);
            }    
            $unique_name = hexdec(uniqid());
            $extension = strtolower($brand_image->getClientOriginalExtension());

            $filename = $unique_name . '.' . $extension;

            $upLocation = 'image/brand/';
            $lastImage = $upLocation . $filename;

            $brand_image->move($upLocation, $filename);
        }
        
        $brand->update([
            'brand_name' => $request->brand_name,
            'image' => $brand_image? $lastImage : $oldImage,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('all.brand')->with('success', 'Brand updated successfully');
    }

    public function destroy($id) {

        Brand::destroy($id);

        return redirect()->back()->with('success', 'Brand destroyed successfully');
    }

    public function restore($id) {

        Brand::withTrashed()->find($id)->restore();

        return redirect()->back()->with('success', 'Brand restored successfully');
    }

    public function forceDelete($id) {

        $brand = Brand::onlyTrashed()->find($id);

        if(File::exists($brand->image)) {
            File::delete($brand->image);
        }

        $brand->forceDelete();

        return redirect()->back()->with('success', 'Brand permanently deleted successfully');
    }
}

