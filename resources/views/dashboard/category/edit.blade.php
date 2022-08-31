@extends('layouts.admin')

@section('title', 'Edit ' . $category->name . ' category')

@section('content')

    <div class="container">
        <h3>Edit Category</h3>
        <form action="{{ route('categories.update', $category->id) }}" method="post">
            @csrf
            @method('patch')
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="name" placeholder="Type Category Name Here"
                    aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ $category->name }}">
                <input class="btn btn-primary" type="submit" value="Update category" id="button-addon2">
            </div>
        </form>
    </div>
@endsection
