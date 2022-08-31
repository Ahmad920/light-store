@extends('layouts.admin')

@section('title', 'Edit '.$product->name)

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        Edit Product
                    </div>
                    <div class="card-body pt-5">
                        <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            @include('dashboard.form')


                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Product') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
