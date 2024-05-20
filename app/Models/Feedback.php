<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'category_id',
        'subject',
        'subcategory_id', // Add subcategory_id to the fillable array
        'name',
        'email',
        'feedback',
    ];

    // Define relationship with FeedbackCategory model (assuming it exists)
    public function category()
    {
        return $this->belongsTo(FeedbackCategory::class, 'category_id');
    }

    // Define relationship with Subcategory model
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    // Define an accessor for category_name
    public function getCategoryNameAttribute()
    {
        return $this->category->name ?? null;
    }


    public function getSubcategoryNameAttribute()
    {
        return $this->subcategory->name ?? null;
    }
}
