<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectUserController extends Controller
{
    public function redirect()
    {
        if(Auth::user()->role == 'admin')
        {
            return redirect()->route('products.index');
        }
        else 
        {
            return redirect()->route('products.getproductsForCustomer');
        }
    }
}
