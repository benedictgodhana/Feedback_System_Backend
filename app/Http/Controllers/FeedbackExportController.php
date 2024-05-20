<?php

namespace App\Http\Controllers;

use App\Exports\FeedbackExport;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FeedbackExportController extends Controller
{
    public function export(Request $request)
    {
        // Fetch filtered feedback based on request parameters
        $filteredFeedback = $this->fetchFilteredFeedback($request);

        // Pass the filtered feedback to the export class
        return Excel::download(new FeedbackExport($filteredFeedback), 'filtered_feedback.xlsx');
    }

    private function fetchFilteredFeedback(Request $request)
    {
        // Implement logic to fetch filtered feedback based on request parameters
        // You can use the parameters from the request to filter feedback from your database

        // For example:
         $category = $request->input('category');
         $subcategory = $request->input('subcategory');
        // Fetch feedback based on the provided filters
        $filteredFeedback = Feedback::where('category_id', $category)->where('subcategory_id', $subcategory)->get();

        // Replace this with your actual filtering logic

        return $filteredFeedback;
    }
}
