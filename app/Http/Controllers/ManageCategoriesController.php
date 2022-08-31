<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageCategoriesController extends Controller
{
    public function show_categories_page()
    {
        $categories = CategoryController::getAllCategories();
        return view('dashboard.category.categories',compact('categories'));
    }

    public static function get_categories()
    {
        $categories = Category::with('subcategories')->get();
        return $categories;
    }
    public static function get_categories_ajax()
    {
        $categories = Category::with('subcategories')->get();
        return response()->json([
            'categories' => $categories,
        ]);
    }

    public static function get_category_name($id)
    {
        $category = Category::findOrFail($id);
        return $category->name;
    }

    //get subcategories ids for a product
    public static function get_subcategories_ids($product_id)
    {
        $subcateories = Product::findOrFail($product_id);
        $subcateories_ids =[];
        
        foreach($subcateories->subcategories as $sub)
        {
            $subcateories_ids[] = $sub->id;
        }
        return $subcateories_ids;
    }

}
