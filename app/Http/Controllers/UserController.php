<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{

    public function index()
    {
        $users =User::all();
        return view('dashboard.users.index',compact('users'));
    }

    // 2️⃣ Show create form
    public function form()
    {
        return view('dashboard.users.form');
    }
    

public function store(Request $request)
{
    // Validation with custom message
    $request->validate([
        'name' => 'required|string|max:255',
        'gender' => 'required',
        'age' => 'required|integer|min:1',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'email.unique' => 'This email is already taken.',
    ]);

    // Handle Image Upload
    $imageName = null;
    if ($request->hasFile('img')) {
        $imageName = time() . '.' . $request->img->extension();
        $request->img->move(public_path('uploads/users'), $imageName);
    }

    // Create User
    User::create([
        'name' => $request->name,
        'gender' => $request->gender,
        'age' => $request->age,
        'email' => $request->email,
        'password' => $request->password,
        'img' => $imageName,
        'email_verified_at' => null,
    ]);

    return redirect()->route('user')->with('success', 'User created successfully!');
}

public function edit($id)
{
    $user = User::findOrFail($id);
    return view('dashboard.users.update', compact('user'));
}
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'gender' => 'required',
        'age' => 'required|integer|min:1',
        'email' => 'required|email|unique:users,email,' . $id,
    ]);

    $user->update($request->only('name','gender','age','email'));

    return redirect()->route('user')->with('success', 'User updated successfully');
}
public function destroy($id)
{
    $user = User::findOrFail($id);

    if ($user->img && file_exists(public_path('uploads/users/'.$user->img))) {
        unlink(public_path('uploads/users/'.$user->img));
    }

    $user->delete();

    return redirect()->route('user')->with('success', 'User deleted successfully');
}

public function seller(){
    return view('seller.index');
}


public function shop(Request $request)
{
    // Get the logged-in user (auth middleware ensures user exists)
    $loggedInUser = auth()->user();

    // Get all categories
    $categories = Category::all();

    // Build product query
    $query = Product::query();

    // Filter by category if selected
    if ($request->filled('CategoryID')) {
        $query->where('CategoryID', $request->CategoryID);
    }

    // Get paginated products
    $products = $query->paginate(12);

    // Return view with logged-in user, products, and categories
    return view('seller.shop', compact('loggedInUser', 'products', 'categories'));
}

public function stores(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if ($user && $user->password === $request->password) {

        
        session([
            'seller_id' => $user->id,
            'seller_name' => $user->name,
        ]);

        return redirect()->route('seller.shop');
    }

    return back()->withErrors([
        'email' => 'Invalid credentials',
    ])->onlyInput('email');
}
   
}
