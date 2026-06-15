<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductsController extends Controller
{
    // Show "Add Product" form
    public function product()
    {
        $Categories = Category::all();
        return view('dashboard.products.index', compact('Categories'));
    }

    // Store new product
    public function productStore(Request $request)
    {
        $request->validate([
            'CategoryID'    => 'required|integer',
            'productName'   => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'productImage'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $newImageName = null;

        if ($request->hasFile('productImage')) {
            $newImageName = time() . '-' . $request->file('productImage')->getClientOriginalName();
            $request->file('productImage')->move(public_path('img/product'), $newImageName);
        }

        Product::create([
            'CategoryID'   => $request->CategoryID,
            'ProductName'  => $request->productName,
            'Price'        => $request->price,
            'ProductImage' => $newImageName,
        ]);

        return redirect()->route('productList');
    }

    // Show product edit form
    public function productEdit($id)
    {
        $Product = Product::findOrFail($id);
        $Categories = Category::all(); 
        return view('dashboard.products.productEdit', compact('Product','Categories'));
    }

    // Show product list with optional category filter
    public function productList(Request $request)
{
    // Get all categories for the dropdown
    $Categories = Category::all();

    // Start query with eager loading
    $query = Product::with('Category');

    // Filter by selected category
    if ($request->filled('CategoryID')) {
        $query->where('CategoryID', $request->CategoryID);
    }

    // Optional search by product name
    if ($request->filled('search')) {
        $query->where('ProductName', 'like', '%' . $request->search . '%');
    }

    // Paginate results and preserve query parameters
    $Products = $query->latest()->paginate(10)->withQueryString();

    // Return view with products and categories 
    return view('dashboard.products.productList', compact('Products', 'Categories'));
}

    // Update existing product
    public function productUpdate(Request $request)
    {
        $request->validate([
            'id'           => 'required|integer',
            'CategoryID'   => 'required|integer',
            'productName'  => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'productImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $Product = Product::findOrFail($request->id);

        $Product->CategoryID  = $request->CategoryID;
        $Product->ProductName = $request->productName;
        $Product->Price       = $request->price;

        if ($request->hasFile('productImage')) {
            $newImageName = time() . '-' . $request->file('productImage')->getClientOriginalName();
            $request->file('productImage')->move(public_path('img/product'), $newImageName);

            if (!empty($Product->ProductImage) && file_exists(public_path('img/product/'.$Product->ProductImage))) {
                unlink(public_path('img/product/'.$Product->ProductImage));
            }

            $Product->ProductImage = $newImageName;
        }

        $Product->save();
        return redirect()->route('productList');
    }

    // Delete product
    public function productDelete($id)
    {
        $Product = Product::findOrFail($id);

        if (!empty($Product->ProductImage) && file_exists(public_path('img/product/'.$Product->ProductImage))) {
            unlink(public_path('img/product/'.$Product->ProductImage));
        }

        $Product->delete();

        return redirect(route('productList'));
    }
    
    public function products(Request $request)
    {
        $Categories = Category::all();
        $query = Product::query();

        // Filter by category if selected
        if ($request->CategoryID) {
            $query->where('CategoryID', $request->CategoryID);
        }

        $Products = $query->paginate(10); 
        return view('dashboard.products.index', compact('Products', 'Categories'));
    }
    

}