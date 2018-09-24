<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BooksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $ratings = $this->ratings;

        $count = count($ratings);
        $score = 0;
        foreach ($ratings as $rating) {
            $score += $rating->id;
        }

        return [
          'title' => $this->title,
            'author' => $this->author->full_name,
          'description' => $this->description,
          'rating' => [
            'star' => $count > 0 ? round($score/$count,0) : 'No Rating Yet',
              'href' => route('ratings.index',$this->id)
          ]
        ];
    }
}
