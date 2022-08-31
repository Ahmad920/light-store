@extends('layouts.admin')

@section('title', 'Edit ' . $subcategory->name . ' subcategory')

@section('content')

    <h3>Edit SubCategory</h3>
    <form action="{{ route('subcategories.update',$subcategory->id) }}" method="post">
        @csrf
        @method('patch')
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="name" value="{{$subcategory->name}}" required>
            <label class="input-group-text" for="for-category">Choose category</label>
            <select class="form-select" id="for-category" name="category_id" required>
                <option value="{{ $subcategory->category_id }}" selected>{{ $category_name }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <input class="btn btn-primary" type="submit" value="Add subcategory">
        </div>
    </form>

@endsection
