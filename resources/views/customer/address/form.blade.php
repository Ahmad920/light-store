<div class="row mb-3">
    <label for="address1" class="col-md-4 col-form-label text-md-end">{{ __('Address1') }}</label>

    <div class="col-md-6">
        <input id="address1" type="text" class="form-control @error('address1') is-invalid @enderror" name="address1"
            value="{{ old('address1') ?? ($address->address1 ?? '') }}" required autocomplete="address1" autofocus>

        @error('address1')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="postal_code" class="col-md-4 col-form-label text-md-end">{{ __('Address2') }}</label>

    <div class="col-md-6">
        <input id="address2" type="text" class="form-control @error('address2') is-invalid @enderror"
            name="address2" value="{{ old('address2') ?? ($address->address2 ?? '') }}" autocomplete="address2"
            autofocus>

        @error('address2')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="postal_code" class="col-md-4 col-form-label text-md-end">{{ __('Postal Code') }}</label>

    <div class="col-md-6">
        <input id="postal_code" type="number" min="0" step=".01"
            class="form-control @error('postal_code') is-invalid @enderror" name="postal_code"
            value="{{ old('postal_code') ?? ($address->postal_code ?? '') }}" required autocomplete="postal_code"
            autofocus>

        @error('postal_code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="country" class="col-md-4 col-form-label text-md-end">{{ __('Country') }}</label>

    <div class="col-md-6">
        <select class="form-select @error('country') is-invalid @enderror countries" aria-label="country" id="countryID"
            name="country" required>
            @isset($address->country)
                <option selected value="{{ $address->country }}">{{ $address->country }}</option>
            @endisset
            <option  disabled>Select your country</option>
            
            @foreach (countries() as $key => $country)
            <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
            @endforeach
        </select>

        @error('country')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


{{-- <div class="row mb-3">
    <label for="state" class="col-md-4 col-form-label text-md-end">{{ __('State') }}</label>

    <div class="col-md-6">
        <select class="form-select @error('state') is-invalid @enderror states" aria-label="state" id="stateID"
            name="state" required>
            <option selected disabled>Select your state</option>
            @isset($address->state)
                <option value="{{ $address->state }}">{{ $address->state }}</option>
            @endisset
        </select>

        @error('state')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('City') }}</label>

    <div class="col-md-6">
        <select class="form-select @error('city') is-invalid @enderror cities" aria-label="city" id="cityID"
            name="city" required>
            <option selected disabled>Select your city</option>
            @isset($address->city)
                <option value="{{ $address->city }}">{{ $address->city }}</option>
            @endisset
        </select>

        @error('city')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div> --}}


<div class="row mb-3">
    <label for="state" class="col-md-4 col-form-label text-md-end">{{ __('State') }}</label>

    <div class="col-md-6">
        <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state"
            value="{{ old('state') ?? ($address->state ?? '') }}"  autocomplete="state" autofocus>

        @error('state')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('City') }}</label>

    <div class="col-md-6">
        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city"
            value="{{ old('city') ?? ($address->city ?? '') }}" required autocomplete="city" autofocus>

        @error('city')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="row mb-3">
    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name of this address') }}</label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
            value="{{ old('name') ?? ($product->name ?? '') }}"  autocomplete="name" autofocus placeholder="Home, Office or First address">

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

