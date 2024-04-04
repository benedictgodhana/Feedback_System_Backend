<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subject',
        'name',
        'email',
        'feedback',
    ];

    // Define relationship with FeedbackCategory model (assuming it exists)
    public function category()
    {
        return $this->belongsTo(FeedbackCategory::class,  'category_id');
    }
}
