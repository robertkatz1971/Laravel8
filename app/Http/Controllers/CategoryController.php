<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::paginate(5);
        $trashedCategories = Category::onlyTrashed()->paginate(3);
        return view('admin.category.index', ['categories' => $categories, 'trashed' => $trashedCategories]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255'
        ]);

        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'Category inserted successfully');
    }

    public function edit($id) {
        $category = Category::findOrFail($id);

        return view('admin.category.edit', ['category' => $category]);
    }

    public function update(Request $request, $id) {

        $validated = $request->validate([
            'category_name' => 'required|max:255'
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('all.category')->with('success', 'Category updated successfully');
    }

    public function destroy($id) {

        Category::destroy($id);

        return redirect()->back()->with('success', 'Category destroyed successfully');
    }

    public function restore($id) {

        Category::withTrashed()->find($id)->restore();

        return redirect()->back()->with('success', 'Category restored successfully');
    }

    public function forceDelete($id) {

        Category::onlyTrashed()->find($id)->forceDelete();

        return redirect()->back()->with('success', 'Category permanently deleted successfully');
    }
}
