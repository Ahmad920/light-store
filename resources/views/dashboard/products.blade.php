@extends('layouts.admin')

@section('content')
    <div class="container">
        @isset($delete_message)
        <div class="alert alert-danger" role="alert">
            The Product has been deleted.
          </div>
        @endisset
        <div class="d-flex justify-content-between">
            <h3>All products</h3>
            <a href="{{route('products.create')}}" class="btn btn-primary">Create Product</a>
        </div>
        
        <div class="row">
            @foreach ($products as $product)
                <div class="col-4 py-2">
                    
                        <div class="card" style="width: 18rem;">
                            {{-- <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" --}}
                            <img src="{{Storage::disk('s3')->url('products/' . $product->image)}}" class="card-img-top"

                                alt="{{ $product->name }}">
                            <div class="card-body">
                                <a href="{{route('products.show',$product->id)}}"><h5 class="card-title">{{ \Illuminate\Support\Str::limit($product->name,20) }}</h5></a>
                                <h5 class="card-title">${{ $product->price }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($product->description,100) }}</p>
                                <div class="d-flex justify-content-between">
                                    @if(isset($product->deleted_at))
                                    <a href="#" class="btn btn-danger">This product was deleted</a>
                                    @else
                                    <a href="{{route('products.edit',$product->id)}}" class="btn btn-primary">edit</a>
                                    {{-- <a href="{{route('products.destroy',$product->id)}}" class="btn btn-danger ms-auto">delete</a> --}}

                                    <form onsubmit="return confirm('Are you sure?')" id="delete_confirmation" action="{{route('products.destroy',$product->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Delete this product" class="btn btn-danger ms-auto">
                                        {{-- <button class="btn btn-delete" type="submit"><img src="/images/trash.svg" /></button> --}}
                        
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    
                </div>
            @endforeach
            {{$products->withQueryString()->links('pagination::bootstrap-5')}}
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
                url: '../categories',
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
                },
                error: function (e){console.log('asdf');console.log(e);}
            });
        }
    $(document).ready(function(){
    });
</script>
@endsection
