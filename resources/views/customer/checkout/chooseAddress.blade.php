@extends('layouts.app')

@section('title','Checkout - Choose Address')

@section('content')

<div class="container">
    <h4>Checkout</h4>
    <div class="d-flex justify-content-between">
        <h3>My Addresses</h3>
        <div>
            <a href="{{route('addresses.create',['checkout'=>1])}}" class="btn btn-primary">Add new address</a>
            <a href="{{route('addresses.index')}}" class="btn btn-primary">Manage my address</a>
        </div>
    </div>
    
    @if(!$addresses->count())
    <div class="card mt-5">
        <div class="card-body my-3">
            <h5 class="card-title">please add new address <a href="{{route('addresses.create',['checkout'=>1])}}" class="btn btn-primary">Add new address</a></h5>
        </div>
    </div>

    @else
    <div class="row row-cols-4  mx-auto">
        @foreach ($addresses as $address)
            <div class="col-4">
                <div class="card {{ $address->active ? 'border-danger' : '' }} g-3   mx-3 mt-3">
                    <div class="card-body">
                        <div style="min-height: 320px">
                            @if ($address->active)
                                <h5 class="card-subtitle mb-2 text-danger">Use this Address</h5>
                            @endif
                            @if ($address->name)
                                <h4 class="card-title">{{ $address->name }}</h4>
                            @endif
                            
                            <address class="py-0"><b>Address1:</b> {{ $address->address1 }}</address>
                            <address class="py-0"><b>Address2:</b> {{ $address->address2 }}</address>
                            <address class=""><b>Postal Code:</b> {{ $address->postal_code }}</address>
                            <p class=""><b>City:</b> {{ $address->city }}</p>
                            <address class=""><b>State:</b> {{ $address->state }}</address>
                            <address class=""><b>Country:</b> {{ $address->country }}</address>
                        </div>
                        
                        @if (!$address->active)
                            <form action="{{ route('addresses.active', [$address->id,'next_route'=>'ad']) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <input type="submit" value="Use this Address" class="btn btn-primary mt-3">
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <br><br>
    <div class="d-flex justify-content-end">
        <a href="{{route('checkout.payment')}}" class="btn btn-success mx-1">Payment</a>
        <a href="{{route('cart.index')}}" class="btn btn-danger mx-1">cancel</a>
    </div>
    
    
    @endif
</div>

@endsection