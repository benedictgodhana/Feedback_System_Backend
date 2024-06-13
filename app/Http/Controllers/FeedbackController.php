<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\FeedbackCategory; // Import the FeedbackCategory model if needed
use App\Models\Subcategory; // Import the FeedbackCategory model if needed
use Carbon\Carbon;
use App\Events\FeedbackCreated; // Import FeedbackCreated event
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FilteredFeedbackExport;

class FeedbackController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'category_id' => 'required|exists:feedback_categories,id',
        'subcategory_id' => 'required|exists:subcategories,id', // Validate subcategory_id
        'subject' => 'required',
        'email' => 'nullable|email',
        'feedback' => 'required',
    ]);

    // Create a new feedback instance
    $feedback = new Feedback();
    $feedback->category_id = $request->category_id;
    $feedback->subcategory_id = $request->subcategory_id; // Save subcategory_id
    $feedback->subject = $request->subject;
    $feedback->name = $request->name;
    $feedback->email = $request->email;
    $feedback->feedback = $request->feedback;
    $feedback->save();

    // Dispatch the FeedbackCreated event
    event(new FeedbackCreated($feedback));

    // Return a JSON response with success message
    return response()->json([
        'message' => 'Feedback submitted successfully',
    ], 201);
}



public function index()
{
    $feedbacks = Feedback::with('category','subcategory')->get()->map(function ($feedback) {
        // Load the 'category' relationship
        $feedback->load('category','subcategory');

        // Access the category name safely
        $feedback->category_id = $feedback->category ? $feedback->category->name : null;
        $feedback->subcategory_id = $feedback->subcategory ? $feedback->subcategory->name : null;


        // Convert created_at to Carbon instance and format it to AM/PM format
        $feedback->created_at = Carbon::parse($feedback->created_at)->format('Y-m-d h:i A');

        // Optionally remove the category object to clean up the response
        unset($feedback->category);

        return $feedback;
    });

    return response()->json($feedbacks);
}





public function getFeedbackCount()
{
    // Get feedback count grouped by category
    $feedbackCounts = Feedback::selectRaw('feedback.category_id, COUNT(*) as count')
                              ->join('feedback_categories', 'feedback.category_id', '=', 'feedback_categories.id')
                              ->groupBy('feedback.category_id')
                              ->get();

    // Prepare response data
    $countsByCategory = [];

    foreach ($feedbackCounts as $feedbackCount) {
        // Assuming you have a 'name' attribute in the FeedbackCategory model
        $categoryName = $feedbackCount->category_name; // Access category name from the joined table
        $countsByCategory[$categoryName] = $feedbackCount->count;
    }

    return $countsByCategory;
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

    public function feedbackCategories(Request $request)
    {
        $query = Feedback::query();

        // Filter by category if category parameter is provided
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $feedbacks = $query->latest()->get();

        return $feedbacks;
    }

    public function show($id)
    {
        // Find the feedback by its ID and eager load the 'category' relationship
        $feedback = Feedback::with('category')->find($id);

        // If feedback is not found, return 404 error response
        if (!$feedback) {
            return response()->json(['error' => 'Feedback not found'], 404);
        }

        // Return the feedback details along with the category name
        return response()->json([
            'id' => $feedback->id,
            'category_id' => $feedback->category->name, // Access category name via relationship
            'subcategory_id' => $feedback->subcategory->name, // Access category name via relationship
            'subject' => $feedback->subject, // Access category name via relationship
            'name' => $feedback->name, // Access category name via relationship
            'email' => $feedback->email, // Access category name via relationship
            'feedback' => $feedback->feedback, // Access category name via relationship




            // Add other feedback attributes as needed
        ]);
    }


    public function exportFilteredFeedback(Request $request)
    {
        // Retrieve filter parameters from the request
        $search = $request->input('search');
        $category = $request->input('category');
        $subcategory = $request->input('subcategory');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Query to retrieve filtered feedback records based on the provided filters
        $filteredFeedback = Feedback::query()
            ->when($search, function ($query) use ($search) {
                $query->where('subject', 'like', '%' . $search . '%');
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->when($subcategory, function ($query) use ($subcategory) {
                $query->where('subcategory_id', $subcategory);
            })
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            })
            ->get();

        // Generate and return Excel file based on the filtered feedback
        return Excel::download(new FilteredFeedbackExport($filteredFeedback), 'filtered_feedback.xlsx');
    }

        public function filterFeedback(Request $request)
        {
            // Retrieve filter parameters from the request
            $search = $request->input('search');
            $category = $request->input('category');
            $subcategory = $request->input('subcategory');
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            // Query to retrieve filtered feedback records
            $query = Feedback::query()->with('category', 'subcategory'); // Eager load category and subcategory relationships

            // Apply filters
            if ($search) {
                $query->where('subject', 'like', '%' . $search . '%');
            }

            if ($category) {
                $query->where('category_id', $category);
            }

            if ($subcategory) {
                $query->where('subcategory_id', $subcategory);
            }

            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }

            // Retrieve filtered records
            $filteredFeedback = $query->get();

            // Return the filtered records
            return response()->json($filteredFeedback);
        }

   }
