<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
{
    return [
        'id' => $this->id,
        'subject' => $this->subject,
        'name' => $this->name,
        'email' => $this->email,
        'feedback' => $this->feedback,
        'category_name' => $this->category->name, // Assuming 'category' is loaded
    ];
}
}
