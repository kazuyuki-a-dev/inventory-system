<?php

namespace App\Models\Concerns;

trait HasStock
{
    public function currentStock(): int
    {
        $in = $this->stockMovements()->where('type', 'in')->sum('quantity');
        $out = $this->stockMovements()->where('type', 'out')->sum('quantity');

        return $in - $out;
    }
}
