<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"               => $this->id,
            "user"             => new UserResource($this->user),
            "type"             => $this->type,
            "price_per_gram"   => $this->price_per_gram,
            "amount"           => $this->amount,
            "remaining_amount" => $this->remaining_amount,
            "status"           => $this->status,
            "created_at"       => $this->created_at,
        ];
    }
}
