<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActualResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'encodeId'=>$this->encodeId,
            'job'=>$this->Encode->job,
            'stockCode'=>$this->Encode->stockCode,
            'stockDescription'=>$this->Encode->stockDescription,
            'encodeId' => $this->encodeId,
            'targetActual' => $this->targetActual,
            'lineActual'=>$this->lineActual,
            'dateActual'=>$this->dateActual,
            'timeDropDown'=>$this->timeDropDown,
        ];
    }
}
