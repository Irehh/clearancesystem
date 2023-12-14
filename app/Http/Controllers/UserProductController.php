<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ImageController;
use Spatie\LaravelImageOptimizer\OptimizerChainFactory;

class UserProductController extends Controller
{
    //

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $products = Product::orderBy('id','DESC')->where('user_id', auth()->user()->id)->paginate(5);

  return view('user.products.index')->with('products', $products);

    } 

    public function create()
    {
        $brand=Brand::get();
        $category=Category::get();
        return view('user.products.create')->with('categories',$category)->with('brands',$brand);
    }



// public function store(Request $request)
// {
//     // Get the authenticated user's user_id
//     $user_id = auth()->user()->id;

//     // Merge the user_id into the request data
//     $request->merge(['user_id' => $user_id]);

//     // Validate the request data
//     $validatedData = $request->validate([
//         'title' => 'required|string',
//         'slug' => 'nullable|string|unique:products',
//         'summary' => 'required|string',
//         'description' => 'nullable|string',
//         'cat_id' => 'required|exists:categories,id',
//         // 'child_cat_id' => 'nullable|exists:categories,id',
//         'price' => 'required|numeric',
//         'brand_id' => 'nullable|exists:brands,id',
//         'discount' => 'nullable|numeric',
//         'status' => 'required|in:active,inactive',
//         'photo' => 'required',
//         'size' => 'nullable|array',
//         'stock' => 'required|integer',
//         'is_featured' => 'sometimes|in:1,0',
//         'condition' => 'nullable|in:default,hot,new',
//         'user_id' => 'required|numeric',
//     ]);

//     $slug=Str::slug($request->title);
//     $count=Product::where('slug',$slug)->count();
//     if($count>0){
//         $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
//     }
//     $validatedData['slug']=$slug;
//     $validatedData['is_featured']=$request->input('is_featured',0);
//     $size=$request->input('size');
//     if($size){
//         $validatedData['size']=implode(',',$size);
//     }
//     else{
//         $validatedData['size']='';
//     }


//     if ($request->hasFile('photo')) {
//         $imageController = new ImageController();
//         $results = $imageController->upload($request, 200, 200, 'photos/1/Products');

//         $validatedData['photo'] = $results['image_path'];
//         // storage/photos/1/Products
//     }

//   $category = Category::findorFail($validatedData['cat_id']);

//     $product =  $category->products()->create([

//         'title' => $validatedData['title'],
//         'slug' => Str::slug($validatedData['slug']),
//         'summary' => $validatedData['summary'],
//         'description' => $validatedData['description'],
//         'cat_id' => $validatedData['cat_id'],
//         // 'child_cat_id' => $validatedData['child_cat_id'],
//         'price' => $validatedData['price'],
//         'brand_id' => $validatedData['brand_id'],
//         'discount' => $validatedData['discount'],
//         'status' => $validatedData['status'],
//         'photo' => $validatedData['photo'],
//         'size' => $validatedData['size'],
//         'stock' => $validatedData['stock'],
//         'is_featured' => $validatedData['is_featured'],
//         'condition' => $validatedData['condition'],
//         'user_id' => $validatedData['user_id'],


//   ]);

//   if($product){
//       request()->session()->flash('success','Product Successfully added');
//   }
//   else{
//       request()->session()->flash('error','Please try again!!');
//   }
//   return redirect()->route('user.products.index');

//       // Save the product

// }

public function store(Request $request)
{
    // Get the authenticated user's user_id
    $user_id = auth()->user()->id;

    // Merge the user_id into the request data
    $request->merge(['user_id' => $user_id]);

    // Validate the request data
    $validatedData = $request->validate([
        
        'title' => 'required|string',
        'slug' => 'nullable|string|unique:products',
        'summary' => 'required|string',
        'description' => 'nullable|string',
        'cat_id' => 'required|exists:categories,id',
        // 'child_cat_id' => 'nullable|exists:categories,id',
        'price' => 'required|numeric',
        'brand_id' => 'nullable|exists:brands,id',
        'discount' => 'nullable|numeric',
        'status' => 'required|in:active,inactive',
        'photo' => 'required',
        'size' => 'nullable|array',
        'stock' => 'required|integer',
        'is_featured' => 'sometimes|in:1,0',
        'condition' => 'nullable|in:default,hot,new,used',
        'user_id' => 'required|numeric',
    ]);

        $slug=Str::slug($request->title);
        $count=Product::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $validatedData['slug']=$slug;
        $validatedData['is_featured']=$request->input('is_featured',0);
        $size=$request->input('size');
        if($size){
            $validatedData['size']=implode(',',$size);
        }
        else{
            $validatedData['size']='';
        }
    
    
        if ($request->hasFile('photo')) {
            $imageController = new ImageController();
            $results = $imageController->upload($request, 200, 200, 'public/photos/userproducts/');
    
            $validatedData['photo'] = $results['image_path'];
        }

    // Set default values if not selected
    $validatedData['condition'] = $request->input('condition', 'default');
    $category = Category::findorFail($validatedData['cat_id']);

    // Save the product
    $product = $category->products()->create([
        'title' => $validatedData['title'],
        'slug' => Str::slug($validatedData['slug']),
        'summary' => $validatedData['summary'],
        'description' => $validatedData['description'],
        'cat_id' => $validatedData['cat_id'],
        // 'child_cat_id' => $validatedData['child_cat_id'],
        'price' => $validatedData['price'],
        'brand_id' => $validatedData['brand_id'],
        'discount' => $validatedData['discount'],
        'status' => $validatedData['status'],
        'photo' => $validatedData['photo'],
        'size' => $validatedData['size'],
        'stock' => $validatedData['stock'],
        'is_featured' => $validatedData['is_featured'],
        'condition' => $validatedData['condition'],
        'user_id' => $validatedData['user_id'],
    ]);

      if($product){
      request()->session()->flash('success','Product Successfully added');
  }
  else{
      request()->session()->flash('error','Please try again!!');
  }

    return redirect()->route('user.products.index');
}





public function edit($id)
    {
        $brand=Brand::get();
        $product=Product::findOrFail($id);
        $category=Category::where('is_parent',1)->get();
        $items=Product::where('id',$id)->get();
        // return $items;
        return view('user.products.edit')->with('product',$product)
                    ->with('brands',$brand)
                    ->with('categories',$category)->with('items',$items);
    }

    public function update(Request $request, $id)
    {
        // Get the authenticated user's user_id
        $user_id = auth()->user()->id;
    
        // Find the product to update
        $product = Product::findOrFail($id);
    
        // Check if the authenticated user is the owner of the product
        if ($product->user_id !== $user_id) {
            return redirect()->back()->with('error', 'You are not authorized to update this product.');
        }
    
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'slug' => 'nullable|string|unique:products,slug,' . $product->id,
            'summary' => 'required|string',
            'description' => 'nullable|string',
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:child_categories,id',
            'price' => 'required|numeric',
            'brand_id' => 'nullable|exists:brands,id',
            'discount' => 'nullable|numeric',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable', // Adjust the image validation rules as needed
            'size' => 'nullable|array',
            'stock' => 'required|integer',
            'is_featured' => 'sometimes|in:1',
            'condition' => 'required|in:default,new,hot',
        ]);
    
        $slug = Str::slug($request->title);
        $count = Product::where('slug', $slug)->where('id', '<>', $product->id)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $validatedData['slug'] = $slug;
        $validatedData['is_featured'] = $request->input('is_featured', 0);
        $size = $request->input('size');
        if ($size) {
            $validatedData['size'] = implode(',', $size);
        } else {
            $validatedData['size'] = '';
        }
    
        // Handle the photo upload if a new photo is provided
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($product->photo) {
                Storage::delete($product->photo);
            }
    
            $imageController = new ImageController();
            $results = $imageController->upload($request, 200, 200, 'photos/1/Products');
            $validatedData['photo'] = $results['image_path'];
        }
    
        // Update the product with the validated data
        $product->update($validatedData);
    
        request()->session()->flash('success', 'Product Successfully updated');
        return redirect()->back();
    }



public function destroy($id)
{
    // Get the authenticated user's user_id
    $user_id = auth()->user()->id;

    // Find the product to delete
    $product = Product::where('id', $id)
        ->where('user_id', $user_id)
        ->first();

    // Check if the product exists and if the authenticated user is the owner
    if (!$product) {
        return redirect()->back()->with('error', 'Product not found or you are not authorized to delete it.');
    }

    // Delete the product's image from the server
    if ($product->photo) {
        Storage::delete($product->photo);
    }

    // Delete the product from the database
    $product->delete();

    request()->session()->flash('success', 'Product Successfully deleted');
    return redirect()->back();
}



}
