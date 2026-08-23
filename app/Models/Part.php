<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function productParts()
    {
        return $this->hasMany(ProductPart::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_parts')
            ->withPivot('quantity_required')
            ->withTimestamps();
    }
}
