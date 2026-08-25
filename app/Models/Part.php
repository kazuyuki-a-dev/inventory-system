<?php

namespace App\Models;

use App\Models\Concerns\HasStock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory, HasStock;
    protected $fillable = ['supplier_id', 'sku', 'name', 'unit', 'price'];

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

    public function stockMovements()
    {
        return $this->morphMany(StockMovement::class, 'stockable');
    }
}
