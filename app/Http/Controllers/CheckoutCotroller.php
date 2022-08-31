<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutCotroller extends Controller
{
    public function chooseAddressOrCreate()
    {  
        $addresses = auth()->user()->addresses;
        $carts_count = Cart::where('user_id',auth()->id())->count();
        return view('customer.checkout.chooseAddress',compact('carts_count','addresses'));
    }

    public function selectPaymentMethod()
    {
        $carts_count = Cart::where('user_id',auth()->id())->count();
        $carts = cart::with('product')->where('user_id',auth()->id())->get();
        return view('customer.checkout.choosePayment',compact('carts_count','carts'));
    }
}
