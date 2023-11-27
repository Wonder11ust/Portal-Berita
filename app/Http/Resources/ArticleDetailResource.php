<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       // return parent::toArray($request);
       return [
        'id'=>$this->id,
        'title'=>$this->title,
        'slug'=>$this->slug,
        'image_url'=>$this->image_url,
        'content'=>$this->content,
        'author'=>$this->user,
        'categories'=>$this->categories,
       // 'comments'=>$this->comments,
       'views'=>$this->views,
       'comments'=>$this->whenLoaded('comments',function(){
        return collect($this->comments)->each(function($comment){
            $comment->user;
            return $comment;
        });
       }),
        'created_at'=>date_format($this->created_at,"d-M-Y"),
    ];
    }
}
