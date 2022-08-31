@extends('layouts.app')

@section('title', 'My Addresses')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between">
            <h3>Shipping Details</h3>
            <h3>My Addresses</h3>
            <a href="{{ route('addresses.create') }}" class="btn btn-primary">Create address</a>
        </div>

        @if (!$addresses->count())
            <div class="card mt-5">
                <div class="card-body my-3">
                    <h5 class="card-title">please add new address <a href="{{ route('addresses.create') }}"
                            class="btn btn-primary">Add new address</a></h5>
                </div>
            </div>
        @else
            <div class="row row-cols-4  mx-auto">
                @foreach ($addresses as $address)
                    <div class="col-4">
                        <div class="card {{ $address->active ? 'border-dark' : '' }} g-3   mx-3 mt-3">
                            <div class="card-body">
                                <div style="min-height: 320px">
                                    @if ($address->name)
                                        <h4 class="card-title">{{ $address->name }}</h4>
                                    @endif
                                    @if ($address->active)
                                        <h5 class="card-subtitle mb-2 text-muted">Main Address</h5>
                                    @endif
                                    <address class="py-0"><b>Address1:</b> {{ $address->address1 }}</address>
                                    <address class="py-0"><b>Address2:</b> {{ $address->address2 }}</address>
                                    <address class=""><b>Postal Code:</b> {{ $address->postal_code }}</address>
                                    <p class=""><b>City:</b> {{ $address->city }}</p>
                                    <address class=""><b>State:</b> {{ $address->state }}</address>
                                    <address class=""><b>Country:</b> {{ $address->country }}</address>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-secondary">Edit</a>
                                    <form action="{{ route('addresses.destroy', $address->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-danger" value="Delete">
                                    </form>
                                </div>
                                @if (!$address->active)
                                    <form action="{{ route('addresses.active', $address->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="submit" value="Set Main Address" class="btn btn-primary mt-3">
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @endif

    </div>

@endsection
