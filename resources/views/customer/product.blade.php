@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container">
        @isset($add_message)
            <div class="alert alert-success" role="alert">
                The product has been added to cart.
            </div>
        @endisset
        @isset($edit_message)
            <div class="alert alert-danger" role="alert">
                The product has been removed from cart.
            </div>
        @endisset

        <div class="d-flex justify-content-between">
            @if (!in_array($product->id, $cart))
                <form action="{{ route('cart.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="d-flex justify-content-between">
                        <div class="quantity buttons_added">
                            <input type="button" value="-" class="minus">
                            <input type="number" step="1" min="1" max="" name="quantity"
                                value="1" title="Qty" class="input-text qty text" size="3" pattern=""
                                inputmode="">
                            <input type="button" value="+" class="plus">
                        </div>
                        <input type="submit" class="btn btn-primary" value="Add to cart">
                    </div>
                </form>
            @else
                <form action="{{ route('cart.destroy', ['product_id' => $product->id, 'user_id' => auth()->id()]) }}"
                    method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger" value="remove from cart">
                </form>
            @endif

        </div>

        <div class="row mt-4">
            <h2>{{ $product->name }}</h2>
            <div class="col-4">
                {{-- <img src="{{ asset('storage/' . $product->image) }}" style="max-width: 100%" alt="{{ $product->name }}"> --}}
                <img src="{{ Storage::disk('s3')->url('products/' . $product->image) }}" style="max-width: 100%" alt="{{ $product->name }}">

            </div>
            <div class="col-8">
                <div class="container">
                    <h4>Price : ${{ $product->price }}</h4>

                    <h4>Description:</h4>
                    <p>{{ $product->description }}</p>


                    @if (!empty($product->size))
                        <h4>size : {{ $product->size }}</h4>
                    @endif

                    @if (!empty($product->return_policy))
                        <h4>Return Policy:</h4>
                        <p>{{ $product->return_policy }}</p>
                    @endif

                    <h4>Category:</h4>
                    <ul>
                        @foreach ($product->subcategories as $subcategory)
                            <span>{{$subcategory->category->name.' '}} => {{ $subcategory->name . ' ,' }}</span>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
