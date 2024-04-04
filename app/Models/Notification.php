<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'feedback_id', // Assuming you have a column to store the associated feedback's ID
    ];

    /**
     * Get the feedback associated with the notification.
     */
    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }
}
