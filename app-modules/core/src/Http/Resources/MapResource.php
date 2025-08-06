<?php

namespace Estivenm0\Core\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MapResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'promotion' => [
                'title' => $this->promotion->title,
                'image' => $this->promotion->image,
                'description' => $this->promotion->description,
                'category' => $this->promotion->category,
                'start_date' => $this->promotion->start_date,
                'end_date' => $this->promotion->end_date,
            ],
        ];
    }
}
