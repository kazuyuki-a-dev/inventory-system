<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPart extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function part()
    {
        return $this->belongsTo(Part::class);
    }
}
