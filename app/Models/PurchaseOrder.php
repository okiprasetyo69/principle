<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'purchase_order_number',
        'distributor_id',
        'product_id',
        'qty',
        'total_price',
        'purchase_order_date',
        'verified_date',
        'vefified_by',
        'status',
        'description'
    ];

    public function distributor()
    {
        return $this->belongsTo(User::class, 'distributor_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'vefified_by', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }    
}
