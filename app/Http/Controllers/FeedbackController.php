<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\FeedbackCategory; // Import the FeedbackCategory model if needed
use Carbon\Carbon;
use App\Events\FeedbackCreated; // Import FeedbackCreated event

class FeedbackController extends Controller
{public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:feedback_categories,id',
            'subject' => 'required',
            'email' => 'nullable|email',
            'feedback' => 'required',
        ]);

        // Create a new feedback instance
        $feedback = new Feedback();
        $feedback->category_id = $request->category_id;
        $feedback->subject = $request->subject;
        $feedback->name = $request->name;
        $feedback->email = $request->email;
        $feedback->feedback = $request->feedback;
        $feedback->save();

        // Dispatch the FeedbackCreated event
        event(new FeedbackCreated($feedback));

        return response()->json(['message' => 'Feedback submitted successfully'], 201);
    }

    public function index()
    {
        $feedbacks = Feedback::with('category')->get()->map(function ($feedback) {
            // Assuming your Category model has a 'name' attribute
            $feedback->category_id = $feedback->category->name;

            // Convert created_at to Carbon instance and format it to AM/PM format
            $feedback->created_at = Carbon::parse($feedback->created_at)->format('Y-m-d h:i A');

            unset($feedback->category); // Optionally remove the category object to clean up the response
            return $feedback;
        });

        return response()->json($feedbacks);
    }





    public function getFeedbackCount()
{
    // Get feedback count grouped by category
    $feedbackCounts = Feedback::selectRaw('category_id, count(*) as count')
                             ->groupBy('category_id')
                             ->get();

    // Prepare response data
    $countsByCategory = [];
    foreach ($feedbackCounts as $feedbackCount) {
        $categoryName = $feedbackCount->category->name; // Assuming you have a 'category' relationship in your Feedback model
        $countsByCategory[$categoryName] = $feedbackCount->count;
    }

    return response()->json($countsByCategory);
}

public function getFeedbackCounts(Request $request)
{
    // Get today's feedback count
    $todayFeedbackCount = Feedback::whereDate('created_at', today())->count();

    // Get this week's feedback count
    $startOfWeek = now()->startOfWeek();
    $endOfWeek = now()->endOfWeek();
    $thisWeekFeedbackCount = Feedback::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

    // Get this month's feedback count
    $startOfMonth = now()->startOfMonth();
    $endOfMonth = now()->endOfMonth();
    $thisMonthFeedbackCount = Feedback::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

    return response()->json([
        'today' => $todayFeedbackCount,
        'this_week' => $thisWeekFeedbackCount,
        'this_month' => $thisMonthFeedbackCount
    ]);
}

public function updateStatus(Request $request, $id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        $feedback->status = $request->input('status');
        $feedback->save();

        return response()->json(['message' => 'Feedback status updated successfully']);
    }

    public function getFeedbackCategoriesCount()
    {
        // Logic to fetch the count of feedback categories
        $count = FeedbackCategory::count(); // Assuming FeedbackCategory is your model for feedback categories

        return response()->json(['count' => $count]);
    }


}
