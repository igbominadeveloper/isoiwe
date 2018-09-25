<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BookCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
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
            $score += $rating->star;
        }

        return [
            'title' => $this->title,
            'author' => $this->author->full_name,
            'star' => $count > 0 ? round($score/$count,0) : 'No Rating Yet',
            'link' => route('books.show',$this->id)
        ];
    }
}
