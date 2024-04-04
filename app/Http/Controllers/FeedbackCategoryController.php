<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedbackCategory;

class FeedbackCategoryController extends Controller
{
    public function index()
    {
        $categories = FeedbackCategory::all();

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            // Add more validation rules as needed
        ]);

        // Create a new feedback category
        $feedbackCategory = FeedbackCategory::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            // Assign additional properties here
        ]);

        // Return a response indicating success
        return response()->json(['message' => 'Feedback category created successfully', 'data' => $feedbackCategory], 201);
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            // Add validation rules for other fields if needed
        ]);

        try {
            // Find the feedback category by ID
            $feedbackCategory = FeedbackCategory::findOrFail($id);

            // Update feedback category attributes
            $feedbackCategory->name = $validatedData['name'];
            $feedbackCategory->description = $validatedData['description'];
            // Update other attributes if needed

            // Save the updated feedback category
            $feedbackCategory->save();

            // Return success response
            return response()->json(['message' => 'Feedback category updated successfully', 'data' => $feedbackCategory], 200);
        } catch (\Exception $e) {
            // Return error response if any exception occurs
            return response()->json(['message' => 'Failed to update feedback category', 'error' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        try {
            // Find the feedback category by ID
            $feedbackCategory = FeedbackCategory::findOrFail($id);

            // Delete the feedback category
            $feedbackCategory->delete();

            return response()->json(['message' => 'Feedback category deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete feedback category'], 500);
        }
    }

}
