<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if(in_array('comments', $request->segments())) {
            return [
                'id' => $this->id,
                'user_id' => $this->user_id,
                'user_name' => $this->user->name,
                'category_id' => $this->category_id,
                'title' => $this->title,
                'content' => $this->content,
                'photo_path' => $this->photo_path,
                'created_at' => $this->created_at,
                'comments' => CommentResource::collection($this->comments),
            ];
        }

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'content' => $this->content,
            'photo_path' => $this->photo_path,
            'created_at' => $this->created_at,
        ];
        
    }
}
