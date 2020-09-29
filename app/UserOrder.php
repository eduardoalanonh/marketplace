<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserOrder
 *
 * @property int $id
 * @property int $user_id
 * @property int $store_id
 * @property string $reference
 * @property string $pagseguro_code
 * @property int $pagseguro_status
 * @property string $items
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Store $store
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Store[] $stores
 * @property-read int|null $stores_count
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder wherePagseguroCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder wherePagseguroStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereUserId($value)
 * @mixin \Eloquent
 */
class UserOrder extends Model
{
    protected $fillable = ['reference', 'pagseguro_status', 'pagseguro_code', 'store_id','items'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function stores()
    {
        return($this->belongsToMany(Store::class,'order_store','order_id'));
    }
}
