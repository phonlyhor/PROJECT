<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
     public function create()
    {
        return view('dashboard.categories.category');
    }

    public function store(Request $request)
    {
        $request->validate([
            'CategoryName' => 'required|string|max:255',
            'CategoryImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('CategoryImage')) {
            $imageName = time() . '-' . $request->file('CategoryImage')->getClientOriginalName();
            $request->file('CategoryImage')->move(public_path('img/product'), $imageName);
        }

        Category::create([
            'CategoryName' => $request->CategoryName,
            'CategoryImage' => $imageName,
        ]);

        return redirect()->route('category.list')->with('success', 'Category created successfully!');
    }

    public function list()
    {
        $categories = Category::latest()->get();
        return view('dashboard.categories.category_list', compact('categories'));
    }
       // Show edit form
    public function categoryShowData($id)
    {
        $Category = Category::findOrFail($id);
        return view('dashboard.categories.categoryEdit', compact('Category'));
    }

    // Update
   public function categoryUpdate(Request $request, $id)
{
    $request->validate([
        'categoryName' => 'required|string|max:255',
        'fileCategoryImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $Category = Category::findOrFail($id);

    // update name
    $Category->CategoryName = $request->categoryName;

    // keep old image by default
    $imageName = $Category->CategoryImage;

    // if upload new image
    if ($request->hasFile('fileCategoryImage')) {

        // delete old image (optional but recommended)
        if ($Category->CategoryImage && file_exists(public_path('img/product/' . $Category->CategoryImage))) {
            unlink(public_path('img/product/' . $Category->CategoryImage));
        }

        $imageName = time() . '-' . $request->file('fileCategoryImage')->getClientOriginalName();
        $request->file('fileCategoryImage')->move(public_path('img/product'), $imageName);
    }

    $Category->CategoryImage = $imageName;
    $Category->save();

    return redirect()->route('category.list')
        ->with('success', 'Category updated!');
}
public function destroy($id)
{
    $Category = Category::findOrFail($id);

    // Optional: delete image file
    if ($Category->CategoryImage && file_exists(public_path('img/product/' . $Category->CategoryImage))) {
        unlink(public_path('img/product/' . $Category->CategoryImage));
    }

    $Category->delete();

    return redirect()->route('category.list')->with('success', 'Category deleted!');
}


}
