<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [ 'title', 'description', 'image', 'catagory', 'quantity', 'price', 'status', 'user_id'];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }

}
