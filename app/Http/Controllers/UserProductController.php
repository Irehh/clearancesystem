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


    public function store(Request $request)
    {
        // Get the authenticated user's user_id
        $user_id = auth()->user()->id;

        // Merge the user_id into the request data
        $request->merge(['user_id' => $user_id]);
        // return $request->all();
        $this->validate($request,[
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
            'stock' => 'nullable|integer',
            'is_featured' => 'sometimes|in:1,0',
            'condition' => 'nullable|in:default,hot,new,used',
            'user_id' => 'required|numeric',
        ]);

        $data=$request->all();
        dd($data);
        $slug=Str::slug($request->title);
        $count=Product::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['is_featured']=$request->input('is_featured',0);
        $size=$request->input('size');
        if($size){
            $data['size']=implode(',',$size);
        }
        else{
            $data['size']='';
        }
        if(!$data['condition']){
            $data['condition'] = 'new';
        }
        if(!$data['stock']){
            $data['stock'] = 1;
        }
        // return $size;
        // return $data;
        $status=Product::create($data);
        if($status){
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
        $product=Product::findOrFail($id);
        $this->validate($request,[
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
            'stock' => 'nullable|integer',
            'is_featured' => 'sometimes|in:1,0',
            'condition' => 'nullable|in:default,hot,new,used',
        ]);

        $data=$request->all();
        $data['is_featured']=$request->input('is_featured',0);
        $size=$request->input('size');
        if($size){
            $data['size']=implode(',',$size);
        }
        else{
            $data['size']='';
        }
        if(!$data['condition']){
            $data['condition'] = 'new';
        }
        if(!$data['stock']){
            $data['stock'] = 1;
        }
        // return $data;
        $status=$product->fill($data)->save();
        if($status){
            request()->session()->flash('success','Product Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('user.products.index');
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
