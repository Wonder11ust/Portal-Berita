<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'slug'=>$this->slug,
            'content'=>$this->content,
            'image_url'=>$this->image_url,
            'author'=>$this->user,
            'views'=>$this->views,
            'created_at'=>date_format($this->created_at,"d-M-Y"),
        ];
    }
}
