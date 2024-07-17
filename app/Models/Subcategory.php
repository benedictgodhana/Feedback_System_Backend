<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{

    use HasFactory;

    protected $table = 'subcategories';

    protected $fillable = [
        'name',
        'description',
        'feedback_category_id',
    ];

    public function category()
    {
        return $this->belongsTo(FeedbackCategory::class, 'feedback_category_id');
    }



    public function feedbacks()
{
    return $this->hasMany(Feedback::class, 'subcategory_id');
}
}
