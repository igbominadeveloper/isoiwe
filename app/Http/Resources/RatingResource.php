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
          'star' => $this->id,
            'comment' => $this->grade,
            'user' => $this->whenPivotLoaded('book_rating', function(){
                return new UserCollection(User::find($this->pivot->user_id));
            })
        ];
    }
}
