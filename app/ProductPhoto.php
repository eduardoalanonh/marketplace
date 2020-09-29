<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductPhoto
 *
 * @property int $id
 * @property int $product_id
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPhoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPhoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPhoto query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPhoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPhoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPhoto whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPhoto whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPhoto whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductPhoto extends Model
{
    protected $fillable = ['image'];

    public function product ()
    {
        return $this->belongsTo(Product::class);
    }
}
