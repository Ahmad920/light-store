@extends('layouts.admin')

@section('title', 'Category')

@section('content')
    <div class="container">

        {{-- Status messages --}}
        @isset($_GET['add_message'])
            <div class="alert alert-success" role="alert">
                The category has been added
            </div>
        @endisset
        @isset($_GET['edit_message'])
            <div class="alert alert-success" role="alert">
                The category has been updated
            </div>
        @endisset
        @isset($_GET['delete_message'])
            <div class="alert alert-danger" role="alert">
                The category has been deleted.
            </div>
        @endisset

        @isset($_GET['sub_add_message'])
            <div class="alert alert-success" role="alert">
                The subcategory has been added
            </div>
        @endisset
        @isset($_GET['sub_edit_message'])
            <div class="alert alert-success" role="alert">
                The subcategory has been updated
            </div>
        @endisset
        @isset($_GET['sub_delete_message'])
            <div class="alert alert-danger" role="alert">
                The subcategory has been deleted.
            </div>
        @endisset
        {{-- end  Status messages --}}

        {{-- Add category form --}}
        <h3>Add Category</h3>
        <form action="{{ route('category.store') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="name" placeholder="Type Category Name Here"
                    aria-label="Recipient's username" aria-describedby="button-addon2" required>
                <input class="btn btn-primary" type="submit" value="Add category" id="button-addon2">
            </div>
        </form>
        {{-- end Add category form --}}

        {{-- Add subcategory form --}}
        <h3>Add SubCategory</h3>
        <form action="{{ route('subcategory.store') }}" method="post">
            @csrf
            <div class="input-group mb-3 @error('name') is-invalid @enderror">
                <input type="text" class="form-control" name="name" placeholder="Type Subcategory Name Here" required>
                <label class="input-group-text" for="for-category">Choose category</label>
                <select class="form-select" id="for-category" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                
                <input class="btn btn-primary" type="submit" value="Add subcategory">
            </div>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </form>
        {{-- end Add subcategory form --}}

        <br><br>
        {{-- show categories and Subcategories --}}
        <h3>Manage Categories & Subcategories</h3>
        <div class="row">

            @if(count($categories))

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Category</th>
                        <th scope="col">Subcategory</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <th scope="row" class="center">{{ $category->name }}</th>
                            <td>
                                @if (count($category->subcategories))
                                    <table class="table table-hover">
                                        <tbody>
                                            @foreach ($category->subcategories as $subcategory)
                                                <tr>
                                                    <th scope="row" class="center">{{ $subcategory->name }}</th>
                                                    <td class=""><a
                                                            href="{{ route('subcategories.edit', $subcategory->id) }}">Edit</a>
                                                    </td>
                                                    <td class="center">
                                                        <form onsubmit="return confirm('Are you sure?')"
                                                            action="{{ route('subcategories.destroy', $subcategory->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="submit" value="Delete"
                                                                class="btn btn-danger ms-auto">
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    There is no subcategory.
                                @endif
                            </td>
                            <td class=""><a href="{{ route('categories.edit', $category->id) }}">Edit</a>
                            </td>
                            <td class="center">
                                <form onsubmit="return confirm('Are you sure?')"
                                    action="{{ route('categories.destroy', $category->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Delete" class="btn btn-danger ms-auto">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>There is no category. Please Add.</p>
            @endif
        </div>
    </div>
@endsection
