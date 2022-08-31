<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id',auth()->id())->paginate(15);
        $carts_count = Cart::where('user_id',auth()->id())->count();
        return view('customer.orders.orders',compact('orders','carts_count'));
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
    public function store2()
    {
        // product_id, order_id,price, quantity
        // address_id , delivery_fee, status,total_price,user id
        if($total_price = Cart::join('products','carts.product_id','=','products.id')->where('carts.user_id',auth()->id())->selectRaw('sum(carts.quantity * products.price)as total')->first())
        {
            $data=[];
            $data['user_id'] = auth()->id();
            $address_id = auth()->user()->addresses()->where('active',1)->first(['id']);
            $data['address_id'] = $address_id->id;
            $data['delivery_fee'] = 20;
            $data['status'] = "Processing";

            //calculate total prices
            
            $data['total_price'] = $total_price->total + $data['delivery_fee'];

            //insert to order table
            $order = Order::create($data);

            //prepare date to pivot table
            $pivotTableData = Cart::join('products','carts.product_id','=','products.id')->where('carts.user_id',auth()->id())->get(['carts.quantity','carts.product_id','products.price']);
            
            //insert to pivot table
            foreach($pivotTableData as $line)
            {
                $order->products()->attach($line->product_id,['quantity'=>$line->quantity,'price'=>$line->price]);
            }
            //clear the user cart
            Cart::where('carts.user_id',auth()->id())->delete();
            
            return redirect()->route('orders.show',[$order->id,"success_message"=>1]);
        }
        else redirect('cart.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        abort_if(auth()->id() != $order->user_id,403);
        $numberOfitemes = 0;
        foreach($order->products as $product)
        {
            $numberOfitemes += $product->pivot->quantity;
        }
        $carts_count = Cart::where('user_id',auth()->id())->count();
        return view('customer.orders.order',compact('order','numberOfitemes','carts_count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update(['status'=> $request->status]);
        $message="success";
        return redirect()->route('orders.showForAdmin',[$order->id,'message'=>1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function getAllOrders()
    {
        $orders = Order::with('user')->paginate(15);
        $carts_count = Cart::where('user_id',auth()->id())->count();
        return view('dashboard.orders.orders',compact('orders','carts_count'));
    }

    public function showForAdmin(Order $order)
    {
        $numberOfitemes = 0;
        foreach($order->products as $product)
        {
            $numberOfitemes += $product->pivot->quantity;
        }
        $carts_count = Cart::where('user_id',auth()->id())->count();
        return view('dashboard.orders.order',compact('order','numberOfitemes','carts_count'));
    }
}
