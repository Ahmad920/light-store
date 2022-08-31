@extends('layouts.admin')

@section('title', $product->name)

@section('content')

    @isset($add_message)
    <div class="alert alert-success" role="alert">
        The product has been added
    </div>
    @endisset
    @isset($edit_message)
    <div class="alert alert-success" role="alert">
        The product has been updated
    </div>
    @endisset
    
    <div class="d-flex justify-content-between">
        <a href="{{route('products.edit',$product->id)}}" class="btn btn-primary">edit</a>
        @if (!empty($product->deleted_at))
            <a href="#" class="btn btn-danger ms-auto">This product was deleted</a>
        @else
            {{-- <a href="{{ route('products.destroy', $product->id) }}" class="btn btn-danger ms-auto">Delete this product</a> --}}

            <form onsubmit="return confirm('Are you sure?')" action="{{ route('products.destroy', $product->id) }}" method="post">
                @csrf
                @method('DELETE')
                <input type="submit" value="Delete this product" class="btn btn-danger ms-auto" >
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

                
                @if(!empty($product->size))
                    <h4>size : {{ $product->size }}</h4>
                @endif

                @if(!empty($product->return_policy))
                    <h4>Return Policy:</h4>
                    <p>{{ $product->return_policy }}</p>
                @endif

                {{-- <h4>Category:</h4>
                <ul>
                @foreach($product->subcategories as $subcategory)
                <span>{{$subcategory->category->name.' '}} => {{$subcategory->name.' ,'}}</span>
                @endforeach
                </ul> --}}
            </div>
        </div>
    </div>

@endsection
