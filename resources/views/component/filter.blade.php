<div class="container">
    <div class="card">
        <div class="card-header">
            <strong>Filter</strong>
        </div>
        <div class="card-body">
            <form action="{{Request::segment(1)=='dashboard' ? route('products.index') : route('products.getproductsForCustomer')}}" method="get">

                <h5>Name</h5>
                <div>
                    {{-- <label for="name" class="col-form-label p-2">Name:</label> --}}
                    <input id="name" type="text"  class="form-control p-2 my-1"  name="name" value="{{ old('name') }}" >
                </div>

                <hr>

                <h5>Category</h5>
                {{-- @foreach ($categories as $category) --}}
                <div class="categories">
                    {{-- <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{$category->id}}" id="{{$category->name}}" name="category[]">
                        <label class="form-check-label" for="{{$category->name}}">
                        {{$category->name}}
                        </label>
                    </div> --}}
                </div>
                    
                {{-- @endforeach --}}

                <hr>

                <h5>Subcategory</h5>
                <div class="subcategories">
                    {{-- @foreach ($categories as $category) --}}
                    {{-- <h6>{{$category->name}}</h6> --}}
                    {{-- @foreach ($category->subcategories as $subcategory) --}}
                    {{-- <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="{{$subcategory->id}}" id="{{$subcategory->name}}-{{$subcategory->id}}" name="subcategory[]">
                        <label class="form-check-label" for="{{$subcategory->name}}-{{$subcategory->id}}">
                        {{$subcategory->name}}
                        </label>
                    </div> --}}
                    {{-- @endforeach
                @endforeach --}}
                        <div class="sub">

                        </div>
                </div>
                

                <hr>

                <h5>Price</h5>
                <div>
                    <label for="from" class="col-form-label d-inline p-2">From:</label>
                    <input  style="width: 80px;" placeholder="0" id="from" type="number" min="0" step=".01" class="form-control d-inline p-2 my-1"  name="price_from" value="{{ old('from')??null }}" >
                </div>
                <div>
                    <label for="to" class="col-form-label d-inline p-2">To:</label>
                    <input  style="width: 80px;" placeholder="1000" id="to" type="number" min="0" step=".01" class="form-control d-inline p-2 my-1"  name="price_to" value="{{ old('to')??null }}" >
                </div>

                <hr>

                <h5>Size</h5>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="m" id="m" name="size[]">
                        <label class="form-check-label" for="m">M</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="s" id="s" name="size[]">
                        <label class="form-check-label" for="s">S</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="l" id="l" name="size[]">
                        <label class="form-check-label" for="l">L</label>
                    </div>
                </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="xl" id="xl" name="size[]">
                        <label class="form-check-label" for="xl">XL</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="xxl" id="xxl" name="size[]">
                        <label class="form-check-label" for="xxl">XXL</label>
                    </div>

                    <div class="row mb-0 mt-4">
                        <div class="col-md-6 ">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Search') }}
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>