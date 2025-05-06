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
            "type"          => $this->type,
            "asset"         => $this->asset,
            "amount"        => $this->amount,
            "balance_after" => $this->balance_after,
            "description"   => $this->description,
            "created_at"    => $this->created_at,

        ];
    }
}
