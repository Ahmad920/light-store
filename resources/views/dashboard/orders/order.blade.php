@extends('layouts.admin')

@section('title','Order Detailes')

@section('content')

<div class="container">
    @if(request('message'))
    <div class="alert alert-success" role="alert">
        The status has been updated successfuly.
        Update the page to see the current status.
    </div>
    @endif

    <div class="alert alert-danger" role="alert" id="failed_message" style="display: none">
        The status didn't change.
    </div>
    <h4>Order detailes</h4>
    <div class="card">
        <div class="card-header">
            Order Information
        </div>
        <div class="card-body">
            <p>Customer Name: {{$order->user->first_name .' '}} {{$order->user->last_name}}</p>
            <p>Order Namber: {{$order->id}}.</p>
            <p>Oreder Placed: {{$order->created_at}}.</p>
            {{-- <p >Status: <b>{{$order->status}}</b>.</p> --}}
            <p>Status: 
                <form action="{{route('orders.update',$order->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-select" id="status_form" >
                        <option {{ $order->status == 'Processing' ? 'selected':'' }} value="Processing">Processing</option>
                        <option {{ $order->status == 'Shipped' ? 'selected':'' }} value="Shipped">Shipped</option>
                        <option {{ $order->status == 'Delivered' ? 'selected':'' }} value="Delivered">Delivered</option>
                        <option {{ $order->status == 'Completed' ? 'selected':''}} value="Completed">Completed</option>
                        <option {{ $order->status == 'Canceled'? 'selected':'' }} value="Canceled">Canceled</option>
                    </select>
                </form>
            </p>
            <p>Number of Items: {{$numberOfitemes}}.</p>
            <p>Pyment Method: Cash on delivery.</p>

            <h5><b>Items Details</b></h5>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Picture</th>
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total Price for the product</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody><?php $index = 1;
                $total_price = 0;
                $delivary_fee = 20; ?>
                    @foreach ($order->products as $product)
                        <tr>
                            <th scope="row">{{ $index }}</th>
                            {{-- <td><img src="{{ asset('storage/' . $product->image) }}"
                                    alt=""class="img-cart"></td> --}}
                            <td><img src="{{ Storage::disk('s3')->url('products/' . $product->image) }}"
                                alt=""class="img-cart"></td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td>{{ $product->pivot->quantity * $product->pivot->price }}</td>
                        </tr>
                        <?php $index++; ?>
                    @endforeach
                    <tr>
                        <td>Delivery fee</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $delivary_fee }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total Price</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $order->total_price }}</td>
                    </tr>
                </tfoot>
            </table>


        </div>
    </div>
</div>
@endsection