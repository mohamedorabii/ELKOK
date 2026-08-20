<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'quantity'           => $this->quantity,
            'price'              => $this->price,
            'total_price'        => $this->total_price,
            'variant_label'      => $this->variant_label,
            'color_name_en'     => $this->color_name_en,
            'color_name_ar'     => $this->color_name_ar,
            'size_name_en'      => $this->size_name_en,
            'size_name_ar'      => $this->size_name_ar,
            'variant_sku'       => $this->variant_sku,
            'product'            => new ProductResource($this->product),
            'variant'            => $this->variant ? [
                'id'    => $this->variant->id,
                'color' => $this->variant->color?->name,
                'size'  => $this->variant->size?->name,
                'sku'   => $this->variant->sku,
            ] : null,
        ];
    }
}