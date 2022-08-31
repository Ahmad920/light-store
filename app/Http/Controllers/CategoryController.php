<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public static function getAllCategories()
    {
        $categories = Category::all();
        return $categories;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->role == 'admin')
        {
            return view('dashboard.category.category');
        }
        else 
        {
            return abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->role == 'admin')
        {
            $data = $this->validation($request);
            $data['user_id'] =auth()->id();
            $category = Category::create($data);
            return redirect()->route('dashboard.categories',['add_message' => 1]);
        }
        else 
        {
            return abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if(auth()->user()->role == 'admin')
        {
            return view('dashboard.category.edit',compact('category'));
        }
        else 
        {
            return abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if(auth()->user()->role == 'admin')
        {
            $data = $this->validation($request);
            $category = Category::findOrFail($category->id)->update($data);
            $edit_message =1;
            return redirect()->route('dashboard.categories',['edit_message'=>1]);
        }
        else 
        {
            return abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if(auth()->user()->role == 'admin')
        {
            $category = Category::findOrFail($category->id)->delete();
            return redirect()->route('dashboard.categories',['delete_message'=>1]);
        }
        else 
        {
            return abort(403);
        }
    }

    public function validation($request)
    {
        return $request->validate([
            'name' => 'required|min:3'
        ]);
    }
}
