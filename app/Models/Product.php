<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $fillable =[
        'name','description','image','price','size','return_policy','deleted_at','code','user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class)->withTimestamps();
    }

    //not workind //not correct
    public function category()
    {
        return $this->hasManyThrough(Category::class,Subcategory::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withTimestamps()->withPivot('quantity','price');
    }
}
