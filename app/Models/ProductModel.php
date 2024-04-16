<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $keyType = 'int';

    public $timestamps = true;
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'category',
        'price',
        'product_image',
        'quantity'
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($product_image) => url('/storage/product-image' . $product_image)
        );
    }
}
