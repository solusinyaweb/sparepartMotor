<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function categoryRelation()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function getTotalStockAttribute()
    {
        $in = $this->stocks()->where('type', 'in')->sum('quantity');
        $out = $this->stocks()->where('type', 'out')->sum('quantity');

        return $in - $out;
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
