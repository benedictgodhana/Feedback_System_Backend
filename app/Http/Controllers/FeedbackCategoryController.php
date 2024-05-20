<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedbackCategory;
use App\Http\Resources\SubcategoryResource;
use App\Models\Subcategory;

class FeedbackCategoryController extends Controller
{
    public function index()
{
    // Fetch all categories along with their associated subcategories
    $categories = FeedbackCategory::with('subcategories')->get();

    // Serialize the data to JSON and return as the API response
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


    public function fetchSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('feedback_category_id', $categoryId)->get();
        return response()->json($subcategories);
    }


    public function subcategories()
    {
        $subcategories = Subcategory::with('category')->get();

        return response()->json($subcategories->map(function ($subcategory) {
            return [
                'id' => $subcategory->id,
                'name' => $subcategory->name,
                'description' => $subcategory->description,
                'feedback_category_id' => $subcategory->category->name,
            ];
        }));
    }

    public function store_subcategories(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'feedback_category_id' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            // Add more validation rules as needed
        ]);

        try {
            // Store the validated data in the database
            $subcategory = Subcategory::create($validatedData);

            // Return a success response with the created subcategory
            return response()->json(['subcategory' => $subcategory], 201);
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json(['error' => 'Failed to store subcategory.'], 500);
        }
    }

    public function getSubcategories($categoryId)
    {
        try {
            // Retrieve subcategories for the specified category ID
            $category = FeedbackCategory::findOrFail($categoryId);
            $subcategories = $category->subcategories;

            // Return subcategories as JSON response
            return response()->json($subcategories);
        } catch (\Exception $e) {
            // Handle the case where the category is not found
            return response()->json(['error' => 'Category not found'], 404);
        }
    }


}
