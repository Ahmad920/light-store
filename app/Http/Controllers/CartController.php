<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->id())
        {
            $carts = cart::with('product')->where('user_id',auth()->id())->get();
            $carts_count = $carts->count();
            return view('customer.cart',compact('carts','carts_count'));
        }
        else
        {
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->id())
        {
            $data = $this->validation($request);
            $data['user_id'] = auth()->id();
            $cart = Cart::create($data);
            return back();
        }
        else
        {
            return redirect()->route('login');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cart $cart)
    {
        if(auth()->id() == $cart->user_id)
        {
            $data = $this->validation($request);
            $cart->update($data);
            return back();
        }
        else
        {
            return redirect()->route('login');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id,$user_id)
    {
        if(auth()->id() == $user_id)
        {
            $cart = Cart::where('product_id',$product_id)->Where('user_id',$user_id);
            $cart->delete();
            return back();
        }
        else
        {
            return redirect()->route('login');
        }
    }

    public function destroyAll($user_id)
    {
        if(auth()->id() == $user_id)
        {
            $cart= Cart::where('user_id',auth()->id());
            $cart->delete();
            return back();
        }
        else
        {
            return redirect()->route('login');
        }
    }

    public function validation(Request $request)
    {
         return $request->validate([
            'quantity' =>'required',
            'product_id' => 'required',
        ]);
    }
}
