<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->rso_name);
        return [
            'id' => Crypt::encryptString($this->id),
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'broker' => $this->whenLoaded('broker'),
            'rso_name' => $this->whenLoaded('property_management', 'name'),
            'created_at' => $this->created_at,
        ];
    }
}
