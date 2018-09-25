<?php

namespace App\Http\Resources;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'star' => $this->star,
            'comment' => $this->comment,
            'user' => $this->user->name
        ];
    }
}
