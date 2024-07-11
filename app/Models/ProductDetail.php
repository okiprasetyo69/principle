<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'description',
        'image_name',
    ];

    protected $appends = ['image_url'];

    public function category()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }

    public function getImageUrlAttribute()
    {
        return asset('/uploads/product/'. $this->image_name);
    }
}
