<?php

namespace App\Listeners;

use App\Events\FeedbackCreated;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendFeedbackNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param FeedbackCreated $event
     * @return void
     */
    public function handle(FeedbackCreated $event)
    {
        // Retrieve the created feedback
        $feedback = $event->feedback;

        // Create a notification for the feedback
        Notification::create([
            'title' => 'New Feedback Created',
            'message' => 'A new feedback has been created.',
            'feedback_id' => $feedback->id,
        ]);
    }
}
