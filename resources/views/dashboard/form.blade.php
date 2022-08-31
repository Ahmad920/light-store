<div class="row mb-3">
    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $product->name??'' }}" required autocomplete="name" autofocus>

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

    <div class="col-md-6">
        <textarea id="description" rows="7" class="form-control @error('description') is-invalid @enderror" name="description"  required autocomplete="description" autofocus>{{ old('description') ?? $product->description??'' }}</textarea>

        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('Price') }}</label>

    <div class="col-md-6">
        <input id="price" type="number" min="0" step=".01" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') ?? $product->price??'' }}" required autocomplete="price" autofocus>

        @error('price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>

    <div class="col-md-6">
        <input id="image" type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror" name="image" required autocomplete="image" autofocus >

        @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="subcategory" class="col-md-4 col-form-label text-md-end">{{ __('Category - Subcategory') }}</label>

    <div class="col-md-6">
        <select class="form-select @error('subcategory') is-invalid @enderror"" aria-label="subcategory" id="subcategory"  name="subcategory[]" multiple required>
            <option selected disabled>You can select more than one</option>
            @foreach($categories as $category)
                <option disabled><b>{{$category->name}}</b></option>
                    @foreach($category->subcategories as $subcategory)
                    <option value="{{$subcategory->id}}" 
                        @isset($subcateories_ids)
                        {{in_array($subcategory->id,$subcateories_ids)?'selected':''}}
                        @endisset
                        ><b>&emsp;{{$subcategory->name}}</b></option>
                    @endforeach
            @endforeach
        </select>

        @error('subcategory')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>



<div class="row mb-3">
    <label for="size" class="col-md-4 col-form-label text-md-end">{{ __('Size') }}</label>

    <div class="col-md-6 pt-2">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="size" id="size1" value="S">
            <label class="form-check-label" for="inlineRadio1">S</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="size" id="size2" value="M">
            <label class="form-check-label" for="inlineRadio2">M</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="size" id="size3" value="L" >
            <label class="form-check-label" for="size3">L</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="size" id="size4" value="XL" >
            <label class="form-check-label" for="size3">XL</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="size" id="size5" value="XXL" >
            <label class="form-check-label" for="size3">XXL</label>
          </div>
    </div>
</div>

<div class="row mb-3">
    <label for="return_policy" class="col-md-4 col-form-label text-md-end">{{ __('Return Policy') }}</label>

    <div class="col-md-6">
        <textarea id="return_policy" rows="5" class="form-control @error('return_policy') is-invalid @enderror" name="return_policy"   autocomplete="description" autofocus>{{ old('return_policy')?? $product->return_policy??''}}</textarea>

        @error('return_policy')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
