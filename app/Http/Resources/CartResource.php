<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'quantity'      => $this->quantity,
            'variant_label'  => $this->variant_label,
            'unit_price'    => $this->unit_price,
            'product'       => new ProductResource($this->product),
            'variant'       => $this->variant ? [
                'id'    => $this->variant->id,
                'color' => $this->variant->color?->name,
                'size'  => $this->variant->size?->name,
                'sku'   => $this->variant->sku,
            ] : null,
            'total'         => $this->quantity * $this->unit_price,
        ];
    }
}