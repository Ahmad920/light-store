@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md 3">
            @include('component.filter')
        </div>

        <div class="col-md-9">
            <div class="container">
                @isset($delete_message)
                    <div class="alert alert-success" role="alert">
                        The Product has been added to cart.
                    </div>
                @endisset
                @isset($delete_message)
                    <div class="alert alert-danger" role="alert">
                        The Product has been removed from cart.
                    </div>
                @endisset
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-4 py-2 px-2">
        
                            <div class="card" style="width: 18rem;height:280;">
                                {{-- <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                    alt="{{ $product->name }}"> --}}
                                <img src="{{ Storage::disk('s3')->url('products/' . $product->image) }}" class="card-img-top"
                                    alt="{{ $product->name }}">
                                <div class="card-body">
                                    <a href="{{ route('products.showProductToCustomer', $product->id) }}">
                                        <h5 class="card-title">{{ \Illuminate\Support\Str::limit($product->name, 20) }}</h5>
                                    </a>
                                    <h5 class="card-title">${{ $product->price }}</h5>
                                    <div style="min-height: 100px;">
                                        <p class="card-text">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                                    </div>
        
                                    @if (!in_array($product->id, $cart))
                                        <form action="{{ route('cart.store') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="d-flex justify-content-between">
                                                <div class="quantity buttons_added">
                                                    <input type="button" value="-" class="minus">
                                                    <input type="number" step="1" min="1" max=""
                                                        name="quantity" value="1" title="Qty" class="input-text qty text"
                                                        size="3" pattern="" inputmode="">
                                                    <input type="button" value="+" class="plus">
                                                </div>
                                                <input type="submit" class="btn btn-primary" value="Add to cart">
                                            </div>
                                        </form>
                                    @else
                                        <form
                                            action="{{ route('cart.destroy', ['product_id' => $product->id, 'user_id' => auth()->id()]) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-danger" value="remove from cart">
                                        </form>
                                    @endif
        
                                </div>
                            </div>
        
                        </div>
                    @endforeach
                    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
        
            </div>
        </div>
    </div>
    
@endsection

@section('js')

<script>
    //show categories & subcategories in filter box
    fetchCategories();
    function fetchCategories()
        {
            
            $.ajax({
                type: "GET",
                url: 'categories',
                dataType: 'json',
                success: function(response){
                    
                    $.each(response,function(key,category){
                        // console.log(category.subcategories);
                        $('.categories').append('<div class="form-check">\
                        <input class="form-check-input" type="checkbox" value="'+category.id+'" id="{{'+category.name+'" name="category[]">\
                        <label class="form-check-label" for="' + category.name + '" >\ '+category.name+'</label>\
                        </div>');
                    });

                    $.each(response,function(key,category){
                        console.log(category.subcategories);
                        $('.subcategories').append('<h6 class="my-2"><b>'+category.name+ '</b></h6>');
                        $.each(category.subcategories,function(key2,subcategory){
                            $('.subcategories').append('<div class="form-check">\
                        <input class="form-check-input" type="checkbox" value="'+subcategory.id+'" id="{{'+subcategory.name+'" name="subcategory[]">\
                        <label class="form-check-label" for="' + subcategory.name + '" >\ '+subcategory.name+'</label>\
                        </div>'
                        )});
                    
                            
                    });
                }
            });
        }
    $(document).ready(function(){
    });
</script>
@endsection
