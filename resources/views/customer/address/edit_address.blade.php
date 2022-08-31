@extends('layouts.app')

@section('title', 'Edit the Address')

@section('content')

    <div class="container">
        <div class="row">
            <h3>Edit Address</h3>
            <div class="card col-9 mx-auto ">
                <div class="card-body">
                    <form action="{{route('addresses.update',$address->id)}}" method="post" class="mt-4">
                        @csrf
                        @method('PATCH')
                        @include('customer.address.form',$address)

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Address') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
