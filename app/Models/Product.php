<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasStock;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasStock;
    protected $fillable = ['category_id', 'customer_id', 'sku', 'name', 'unit', 'price'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function productParts()
    {
        return $this->hasMany(ProductPart::class);
    }

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'product_parts')
            ->withPivot('quantity_required')
            ->withTimestamps();
    }

    public function productionOrders()
    {
        return $this->hasMany(ProductionOrder::class);
    }

    public function stockMovements()
    {
        return $this->morphMany(StockMovement::class, 'stockable');
    }
}
