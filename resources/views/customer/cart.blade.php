@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <div class="container">
        <h3>Shopping Cart</h3>
        <div class="card">
            <div class="card-body">


                @if ($carts_count)
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
                                    {{-- <td><img src="{{ asset('storage/' . $cart->product->image) }}"
                                            alt=""class="img-cart"></td> --}}
                                    <td><img src="{{ Storage::disk('s3')->url('products/' . $cart->product->image) }}"
                                        alt=""class="img-cart"></td>
                                    <td>{{ $cart->product->name }}</td>
                                    <td>{{ $cart->product->size ?? '-' }}</td>
                                    <td>{{ $cart->quantity }}</td>
                                    <td>{{ $cart->quantity * $cart->product->price }}</td>
                                    <td>
                                        <form
                                            action="{{ route('cart.destroy', ['product_id' => $cart->product->id, 'user_id' => auth()->id()]) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-danger" value="remove from cart">
                                        </form>
                                    </td>
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
                                <td>Total Proice</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $total_price + $delivary_fee }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="d-flex justify-content-between">
                        <a href="{{route('address.choose')}}" class="btn btn-primary">Checkout</a>
                        <form action="{{route('cart.destroyall',['user_id'=>auth()->id()])}}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-danger" value="remove from cart">
                        </form>
                    </div>
                @else
                    <p>There is no product in cart. <a href="{{ route('products.getproductsForCustomer') }}"
                            class="btn btn-primary">Add Prodcuts to the
                            cart</a></p>
                @endif

                
                
            </div>
        </div>
    </div>
@endsection
