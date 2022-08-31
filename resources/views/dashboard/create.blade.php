@extends('layouts.admin')

@section('title', 'Create Product')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        Add Product
                    </div>
                    <div class="card-body pt-5">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @include('dashboard.form', ['product' => new App\Models\Product()])


                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add Product') }}
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
