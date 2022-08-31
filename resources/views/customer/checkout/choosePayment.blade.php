@extends('layouts.app')

@section('title','Checkout - Choose Payment')

@section('content')

    <div class="container">
        <h4>Checkout</h4>

        <div class="card">
            <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Picture</th>
                                <th scope="col">Product</th>
                                <th scope="col">Size</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total Price for the product</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody><?php $index = 1;
                        $total_price = 0;
                        $delivary_fee = 20; ?>
                            @foreach ($carts as $cart)
                                <tr>
                                    <th scope="row">{{ $index }}</th>
                                    <td><img src="{{ asset('storage/' . $cart->product->image) }}"
                                            alt=""class="img-cart"></td>
                                    <td>{{ $cart->product->name }}</td>
                                    <td>{{ $cart->product->size ?? '-' }}</td>
                                    <td>{{ $cart->quantity }}</td>
                                    <td>{{ $cart->quantity * $cart->product->price }}</td>
                                    <?php $total_price += $cart->quantity * $cart->product->price; ?>
                                </tr>
                                <?php $index++; ?>
                            @endforeach
                            <tr>
                                <td>Delivery fee</td>
                                <td></td>
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
                                <td></td>
                                <td>{{ $total_price + $delivary_fee }}</td>
                            </tr>
                        </tfoot>
                    </table>


                
            </div>
        </div>


        <div class="card mt-4">
            <div class="card-body">
                <h5>Select a payment method</h5>
                <div class="my-4">
                
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                            Cash on Delivery (COD)
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" disabled>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Credit Card (Soon)
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" disabled>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Paypal (Soon)
                        </label>
                      </div>
                </div>

                <a href="{{route('orders.store2')}}" class="btn btn-success" onclick="confirm('Confirn this order')">Place Order</a>
            </div>
        </div>
        

    </div>
@endsection