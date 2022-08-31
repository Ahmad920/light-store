<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    // functions form admin 


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = request('search');
        $getProducts = Product::when($search,function($query,$search){
            $query->where('name','LIKE',"%$search%");
        });

        // start get products by filter fields

        if( $request->has('name') || $request->has('category') || $request->has('subcategory') || $request->has('price_from') || $request->has('price_to') || $request->has('size'))
        {
            $getProducts->leftJoin('product_subcategory','products.id','=','product_subcategory.product_id');
            $getProducts->leftJoin('subcategories','product_subcategory.subcategory_id','=','subcategories.id');
            $getProducts->leftJoin('categories','subcategories.category_id','=','categories.id');
            $getProducts->select('products.*');
            $getProducts->distinct('products.id');
        }

        if(!is_null(request('name')))
        {
            $getProducts->where('products.name','LIKE','%'.request('name').'%');
        }

        if($request->has('category'))
        {
            $getProducts->whereIn('categories.id',request('category'));
        }

        if($request->has('subcategory'))
        {
            $getProducts->whereIn('subcategories.id',request('subcategory'));
        }

        if(!is_null(request('price_from')))
        {
            $getProducts->where('products.price','>=',request('price_from'));
        }

        if(!is_null(request('price_to')))
        {
            $getProducts->where('products.price','<=',request('price_to'));
        }

        if($request->has('size'))
        {
            $getProducts->whereIn('products.size',request('size'));
        }

        // end get products by filter fields

        $products = $getProducts->paginate(15);
        
        if(!empty($request->delete_message)){
        $delete_message = $request->delete_message;
        return view('dashboard.products',compact('products','delete_message'));
        }
        else 
        {
            return view('dashboard.products',compact('products'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ManageCategoriesController::get_categories();
        return view('dashboard.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validation($request);
        $data['user_id'] = auth()->id();
        //$path = request('image')->store('products');
        $image = $request->file(key:'image');
        $path = time().$image->getClientOriginalName();
        $data['image'] = $path;
        $image->storeAs('products',$path,'s3');
        $subcategories = [];
        $subcategories = $data['subcategory'];
        unset($data['subcategory']);
        $product = Product::create($data);
        $product->subcategories()->sync($subcategories);
        return redirect()->route('products.show',[$product->id,'add_message'=>1]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Request $request)
    {
        // abort_if(auth()->id() != $product->user_id,403);
        $add_message = $request->add_message;
        $edit_message = $request->edit_message;
        if(!empty($request->add_message))
        return view('dashboard.product',compact('product','add_message'));
        elseif(!empty($request->edit_message))
        return view('dashboard.product',compact('product','edit_message'));
        else 
        return view('dashboard.product',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $subcateories_ids = ManageCategoriesController::get_subcategories_ids($product->id);
        $categories = ManageCategoriesController::get_categories();
        return view('dashboard.edit',compact('product','categories','subcateories_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $this->validation($request);
        $data['user_id'] = auth()->id();
        //$path = request('image')->store('products');
        $image = $request->file(key:'image');
        $path = time().$image->getClientOriginalName();
        $image->storeAs('products',$path,'s3');
        $data['image'] = $path;
        $subcategories = [];
        $subcategories = $data['subcategory'];
        unset($data['subcategory']);
        $product->update($data);
        $product->subcategories()->wherePivot('product_id',$product->id)->detach();
        $product->subcategories()->sync($subcategories);
        return redirect()->route('products.show',[$product->id,'add_message'=>1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //$product->delete();
        Product::findOrFail($product->id)->update(['deleted_at' => \Carbon\Carbon::now()]);
        return redirect()->route('products.index',['delete_message'=> 1]);
    }

    public function validation(Request $request)
    {
         return $request->validate([
            'name' =>'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|mimes:jpeg,jpg,png',
            'size' => 'min:1',
            'return_policy' =>'',
            'subcategory' => 'required'
        ]);
    }


    // functions for user
    public function getproductsForCustomer(Request $request)
    {
        $search = request('search');
        // get all products 
        $products2 = Product::query();
        $products2->whereNull('products.deleted_at');

        //search in products by name
        $products2->when($search,function($query,$search){
            $query->where('name','LIKE',"%$search%");
        });

        // start get products by filter fields

        if( $request->has('name') || $request->has('category') || $request->has('subcategory') || $request->has('price_from') || $request->has('price_to') || $request->has('size'))
        {
            $products2->leftJoin('product_subcategory','products.id','=','product_subcategory.product_id');
            $products2->leftJoin('subcategories','product_subcategory.subcategory_id','=','subcategories.id');
            $products2->leftJoin('categories','subcategories.category_id','=','categories.id');
            $products2->select('products.*');
            $products2->distinct('products.id');
        }

        if(!is_null(request('name')))
        {
            $products2->where('products.name','LIKE','%'.request('name').'%');
        }

        if($request->has('category'))
        {
            $products2->whereIn('categories.id',request('category'));
        }

        if($request->has('subcategory'))
        {
            $products2->whereIn('subcategories.id',request('subcategory'));
        }

        if(!is_null(request('price_from')))
        {
            $products2->where('products.price','>=',request('price_from'));
        }

        if(!is_null(request('price_to')))
        {
            $products2->where('products.price','<=',request('price_to'));
        }

        if($request->has('size'))
        {
            $products2->whereIn('products.size',request('size'));
        }

        // end get products by filter fields

        $products = $products2->paginate(15);

        $cart = Cart::where('user_id',auth()->id())->pluck('product_id')->toArray();
        $carts_count = count($cart);

        if(!empty($request->add_to_cart_message)){
        $add_to_cart_message = $request->delete_message;
        return view('customer.products',compact('products','add_to_cart_message','cart','carts_count'));
        }
        elseif(!empty($request->remove_from_cart_message)){
            $remove_from_cart_message = $request->remove_from_cart_message;
            return view('customer.products',compact('products','remove_from_cart_message','cart','carts_count'));
            }
        else 
        {
            return view('customer.products',compact('products','cart','carts_count'));
        }
    }

    public function showProductToCustomer(Product $product, Request $request)
    {
        // abort_if(auth()->id() != $product->user_id,403);
        $cart = Cart::where('user_id',auth()->id())->pluck('product_id')->toArray();
        $carts_count = count($cart);
        $add_to_cart_message = $request->add_to_cart_message;
        $remove_from_cart_message = $request->remove_from_cart_message;

        if(!empty($request->add_to_cart_message)){
            return view('customer.product',compact('product','add_to_cart_message','cart','carts_count'));
        }
        elseif(!empty($request->remove_from_cart_message))
            return view('customer.product',compact('product','remove_from_cart_message','cart','carts_count'));
        else 
            return view('customer.product',compact('product','cart','carts_count'));
    }
}
