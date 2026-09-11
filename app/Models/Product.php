<?php


namespace App\Models;



use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_title',
        'product_description',
        'product_quantity',
        'product_price',
        'product_image',
        'product_category',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<Review, $this> */
    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }
}
