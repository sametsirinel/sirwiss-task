<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\Concerns\ProductType;
use App\Models\Concerns\ProductStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "status" => ProductStatus::getNameFromValue($this->status),
            "type" => ProductType::getNameFromValue($this->type),
            "version" => $this->version,
            "user" => $this->user,
        ];
    }
}
