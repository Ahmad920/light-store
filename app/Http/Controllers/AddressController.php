<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use Illuminate\Http\Request;



class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::all();
        $carts_count = Cart::where('user_id',auth()->id())->count();
        return view('customer.address.addresses',compact('addresses','carts_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carts_count = Cart::where('user_id',auth()->id())->count();

        return view('customer.address.create_address',compact('carts_count'));
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
        $address = Address::create($data);
        return session('next_route') !== null ? redirect()->route(session('next_route')) : redirect()->route('addresses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        abort_if(auth()->id() != $address->user_id,403);
        $carts_count = Cart::where('user_id',auth()->id())->count();
        return view('customer.address.edit_address',compact('address','carts_count'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        $data = $this->validation($request);
        $address->update($data);
        return session('next_route') !== null ? redirect()->route(session('next_route')) : redirect()->route('addresses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        abort_if(auth()->id() != $address->user_id,403);
        $address->delete();
        return session('next_route') !== null ? redirect()->route(session('next_route')) : redirect()->route('addresses.index');
    }

    public function active(Address $address)
    {
        abort_if(auth()->id() != $address->user_id,403);
        Address::where('user_id',auth()->id())->update(['active' => 0]);
        $address->update(['active' => 1]);
        return request(['next_route']) !== null ? redirect()->route('address.choose') : redirect()->route('addresses.index');
    }

    //active the address when storeit 
    public function storeAndActive(Request $request)
    {
        $data = $this->validation($request);
        $data['user_id'] = auth()->id();
        $data['active'] = 1;
        $address = Address::create($data);
        return session('next_route') !== null ? redirect()->route(session('next_route')) : redirect()->route('address.choose');
    }

    public function validation(Request $request)
    {
        return $request->validate([
            'address1' => 'required|string|min:10',
            'address2' => '',
            'postal_code' => 'min:4|numeric',
            'country' =>    'required',
            'city' => 'required',
            'state' => '',
            'name' => ''
        ]);
    }
}
