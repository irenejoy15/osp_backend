<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WipMasterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'job'=> ltrim($this->Job,0),
            'stockCode' => $this->StockCode,
            'stockDescription' => $this->StockDescription
        ];
    }
}
