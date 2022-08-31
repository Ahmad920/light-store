<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutCotroller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ManageCategoriesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RedirectUserController;
use App\Http\Controllers\SubcategoryController;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('products.getproductsForCustomer');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/redirect',[RedirectUserController::class,'redirect']);




Route::middleware(['auth', 'is_admin'])->group(function () {
    //admin dashboard - products routes
    Route::resource('dashboard/products', ProductController::class);

    //admin dashbord - store category
    Route::post('dashboard/categories',[CategoryController::class,'store'])->name('category.store');
    //admin dashbord - delete category
    Route::delete('dashboard/categories/{category}',[CategoryController::class,'destroy'])->name('categories.destroy');
    //admin dashbord - edit category
    Route::get('dashboard/categories/{category}',[CategoryController::class,'edit'])->name('categories.edit');
    //admin dashbord - update category
    Route::patch('dashboard/categories/{category}',[CategoryController::class,'update'])->name('categories.update');

    //admin dashbord - store subcategory
    Route::post('dashboard/subcategories',[SubcategoryController::class,'store'])->name('subcategory.store');
    //admin dashbord - delete subcategory
    Route::delete('dashboard/subcategories/{subcategory}',[SubcategoryController::class,'destroy'])->name('subcategories.destroy');
    //admin dashbord - edit subcategory
    Route::get('dashboard/subcategories/{subcategory}',[SubcategoryController::class,'edit'])->name('subcategories.edit');
    //admin dashbord - update category
    Route::patch('dashboard/subcategories/{subcategory}',[SubcategoryController::class,'update'])->name('subcategories.update');

    //admin dashboard - orders
    Route::get('dashboard/orders',[OrderController::class,'getAllOrders'])->name('orders.all');
    Route::get('dashboard/orders/{order}',[OrderController::class,'showForAdmin'])->name('orders.showForAdmin');
    Route::patch('dashboard/orders/{order}',[OrderController::class,'update'])->name('orders.update');


});

Route::middleware(['auth',])->group(function () {
    //show main categories page
    Route::get('dashboard/categories',[ManageCategoriesController::class,'show_categories_page'])->name('dashboard.categories');
    //cart routes
    //Route::resource('cart',CartController::class);
    Route::get('cart',[CartController::class,'index'])->name('cart.index');
    Route::post('cart',[CartController::class,'store'])->name('cart.store');
    Route::delete('cart/{product_id}/{user_id}',[CartController::class,'destroy'])->name('cart.destroy');
    // clear cart route
    Route::delete('cart/{user_id}',[CartController::class,'destroyAll'])->name('cart.destroyall');

    //address route
    Route::Resource('customer/addresses',AddressController::class);
    //active address route
    Route::patch('/customer/addresses/{address}/acitve',[AddressController::class,'active'])->name('addresses.active');
    //store address and active
    Route::post('/customer/addresses/acitve',[AddressController::class,'storeAndActive'])->name('addresses.storeAndActive');

    //checkout
    //choose address route
    Route::get('customer/checkout/address',[CheckoutCotroller::class,'chooseAddressOrCreate'])->name('address.choose');
    //select payemnt method
    Route::get('customer/checkout/paymentmethod',[CheckoutCotroller::class,'selectPaymentMethod'])->name('checkout.payment');

    //Orders
    Route::get('customer/orders/create',[OrderController::class,'store2'])->name('orders.store2');
    Route::get('customer/orders/{order}',[OrderController::class,'show'])->name('orders.show');
    Route::get('customer/orders',[OrderController::class,'index'])->name('orders.index');
    

});

// products list page

Route::get('/products',[ProductController::class,'getproductsForCustomer'])->name('products.getproductsForCustomer');
// show product page
Route::get('/products/{product}',[ProductController::class,'showProductToCustomer'])->name('products.showProductToCustomer');
//ajax get categories
Route::get('/categories',[ManageCategoriesController::class,'get_categories']);