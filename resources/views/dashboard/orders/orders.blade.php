@extends('layouts.admin')

@section('title','All Orders')

@section('content')

<div class="container">
    <h4>My orders</h4>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order Number</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Order Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">Total Price</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody><?php $index = 1;?>
                    @foreach ($orders as $order)
                        <tr>
                            <th scope="row">{{ $index }}</th>
                            <td><a href="{{route('orders.showForAdmin',$order->id)}}">{{$order->id}}</a></td>
                            <td><a href="">{{$order->user->first_name .' '}} {{$order->user->last_name}}</a></td>
                            <td>{{ \Carbon\Carbon::parse($order->created_at)->toDateString() }}</td>
                            <td>{{ $order->status}}</td>                           
                            <td>{{ $order->total_price }}</td>
                        </tr>
                        <?php $index++; ?>
                    @endforeach
                </tbody>
            </table>

            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection