<div class="container">
  <h4>Dashboard</h4>
      <div class="list-group my-3">
        <a href="{{route('products.index')}}" class="list-group-item list-group-item-action {{Request::segment(2)=="products"?'active':''}}" aria-current="true">
          Products
        </a>
        <a href="{{route('dashboard.categories')}}" class="list-group-item list-group-item-action {{Request::segment(2)=="categories"?'active':''}}">Categories & Subcategories</a>
        <a href="{{route('orders.all')}}" class="list-group-item list-group-item-action {{Request::segment(2)=="orders"?'active':''}}">Orders</a>
        {{-- <a href="#" class="list-group-item list-group-item-action {{Request::segment(2)=="filter"?'active':''}}">Filter</a>  --}}
      </div>
</div>
@if (Request::segment(2) == 'products')
  <br>
  @include('component.filter')
@endif
