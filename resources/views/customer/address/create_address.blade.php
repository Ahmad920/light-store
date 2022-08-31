@extends('layouts.app')

@section('title', 'Create an Address')

@section('content')

    <div class="container">
        <div class="row">
            <h3>Add New Address</h3>
            <div class="card col-9 mx-auto ">
                <div class="card-body">
                    <form action="{{request('checkout')?route('addresses.storeAndActive'):route('addresses.store')}}" method="post" class="mt-4">
                        @csrf
                        @include('customer.address.form')

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add Address') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
