<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public function products(): hasMany
    {
        return $this->hasMany(Product::class);
    }

    protected $fillable=['name', 'code', 'description', 'image'];
}
