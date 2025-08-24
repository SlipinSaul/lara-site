<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'code', 'price', 'category_id', 'description', 'image', 'new', 'hit', 'recommend', 'count'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function getPriceForCount(): int
    {
        if(!is_null($this->pivot)){
           return $this->pivot->count * $this->price;
        }
        return $this->price;
    }

    public function setNewAttribute($value)
    {

    }

    public function isNew()
    {
        return $this->new===1;
    }

    public function isHit()
    {
        return $this->hit===1;
    }


    public function isRecommend()
    {
        return $this->recommend===1;
    }

    public function isAvailable()
    {
        return !$this->trashed() && $this->count>0;
    }

}
