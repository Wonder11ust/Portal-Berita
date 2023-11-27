<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
        'id'=>$this->id,
        'comment'=>$this->comment,
        'user_id'=>$this->user_id,
        'article_id'=>$this->article_id,
        'commentator'=>$this->whenLoaded('user'),
        'created_at'=>date_format($this->created_at,"d-M-Y")
       ];
    }
}
