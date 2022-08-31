<?php

namespace App\Http\Controllers;

use App\Models\Subcategories;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
            $subcategories = Subcategory::all();
            return $subcategories;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $subcategory = Subcategory::create($data);
            return redirect()->route('dashboard.categories',['sub_add_message' => 1]);
        }
        else 
        {
            return abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $subcategory)
    {
        if(auth()->user()->role == 'admin')
        {
            $categories = ManageCategoriesController::get_categories();
            $category_name = ManageCategoriesController::get_category_name($subcategory->category_id);
            return view('dashboard.category.edit_subcategory',compact('subcategory','categories','category_name'));
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
     * @param  \App\Models\Subcategories  $subcategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        if(auth()->user()->role == 'admin')
        {
            //dd($request);
            $data = $this->validation($request);
            $data['updated_at'] = \Carbon\Carbon::now();
            $subcategory->update($data);
            return redirect()->route('dashboard.categories',['sub_edit_message' => 1]);
        }
        else 
        {
            return abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->role == 'admin')
        {
            //$subcategory->delete();
            Subcategory::findOrFail($id)->delete();
            return redirect()->route('dashboard.categories',['sub_delete_message' => 1]);
        }
        else 
        {
            return abort(403);
        }
    }

    public function validation($request)
    {
        return $request->validate([
            'name' => 'required|min:3|unique:subcategories,name,category_id',
            'category_id' => 'required|numeric'
        ]);
    }
}
