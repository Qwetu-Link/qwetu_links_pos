<?php

namespace App\Http\Resources\v1\account;

use App\Http\Resources\v1\auth\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'businessName' => $this->business_name,
            'location' => $this->location,
            'contact' => $this->contact,
            'email' => $this->email,
            'isActive' => $this->is_active,
            'users' => UserResource::collection($this->users),
            'branches' => BranchResource::collection($this->branches),
        ];
    }
}
