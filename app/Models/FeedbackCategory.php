<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    // Relationship to Feedback
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'category_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
}
