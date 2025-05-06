<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"            => $this->id,
            "user"          => new UserResource($this->user),
            "balance_toman" => $this->balance_toman,
            "balance_gold"  => $this->balance_gold,
            "update_at"     => $this->update_at,
            "created_at"    => $this->created_at,
        ];
    }
}
