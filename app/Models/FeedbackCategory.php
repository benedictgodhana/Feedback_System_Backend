<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackCategory extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(FeedbackCategory::class);
    }
    protected $fillable = [
        'name',
        'description'
    ];

    // In Category model
public function feedbacks()
{
    return $this->hasMany(\App\Models\Feedback::class, 'category_id');
}

}
