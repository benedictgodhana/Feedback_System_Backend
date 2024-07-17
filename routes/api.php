<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController; // Add this line to import the ServiceController
use App\Http\Controllers\RoleController; // Add this line to import the ServiceController
use App\Http\Controllers\FeedbackCategoryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FeedbackExportController;
use App\Http\Controllers\NotificationController;
use App\Models\FeedbackCategory;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// routes/api.php
Route::post('/export', [FeedbackController::class, 'export']);
Route::patch('/feedbacks/{id}', [FeedbackController::class, 'updateStatus']);
Route::get('/users/count', [UserController::class, 'getUserCount']);
Route::get('/Admin/count', [UserController::class, 'getAdminCount']);
Route::get('/SuperAdmin/count', [UserController::class, 'getSuperAdminCount']);
Route::get('/feedback-categories/{category}/feedback_sub_categories', [FeedbackController::class, 'getSubcategories']);
Route::get('/categories/{category}/feedback_sub_categories', [FeedbackController::class, 'getFeedbackSubcategories']);

Route::get('/users', [UserController::class, 'getAllUsers']);
Route::put('/users/{id}', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::put('/users/update-profile', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::put('/users/change-password', [UserController::class, 'changePassword'])->middleware('auth:sanctum');
Route::get('/roles', [RoleController::class, 'index']);
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/employees', [UserController::class, 'getEmployees']);
Route::post('/employees/assign-service', [UserController::class, 'assignService']);
Route::get('/feedback-categories', [FeedbackCategoryController::class, 'index']);
Route::post('/feedback-categories', [FeedbackCategoryController::class,'store']);
Route::post('/feedback', [FeedbackController::class, 'store']);
Route::get('/feedbacks', [FeedbackController::class, 'index']);
Route::get('/feedback/count', [FeedbackController::class, 'getFeedbackCount']);
Route::put('/feedback-categories/{id}', [FeedbackCategoryController::class, 'update'])->name('feedback-categories.update');
Route::delete('/feedback-categories/{id}', [FeedbackCategoryController::class, 'destroy']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::get('/feedback/counts', [FeedbackController::class, 'getFeedbackCounts']);
Route::get('/feedback/export', [FeedbackExportController::class,'export']);
Route::put('feedback/update-status/{id}', [FeedbackController::class, 'updateStatus']);
Route::get('/notifications', [NotificationController::class,'index']);
Route::get('/notifications/count', [NotificationController::class, 'getUnreadNotificationCount']);
Route::post('/notifications/{id}/mark-as-read', [NotificationController::class,'markAsRead']);
Route::get('feedback/categories/count', [FeedbackController::class, 'getFeedbackCategoriesCount']);
Route::get('/feedbackcategories_all', [FeedbackController::class,'feedbackCategories']);
Route::get('/subcategories', [FeedbackCategoryController::class, 'subcategories']);
Route::post('/feedback-subcategories', [FeedbackCategoryController::class,'store_subcategories']);
Route::get('/feedbacks/{id}', [FeedbackController::class, 'show']);
Route::middleware('auth:sanctum')->get('/Authuser', [UserController::class,'getUserData']);
Route::post('/filteredfeedback/export', [FeedbackController::class,'exportFilteredFeedback'])->name('feedback.export');
Route::post('/feedback/filter', [FeedbackController::class,'filterFeedback']);
Route::get('/filtered-feedbacks', [FeedbackController::class,'getFilteredFeedbacks']);
Route::post('/feedback/filter/export', [FeedbackController::class,'exportFilteredFeedback'])->name('feedback.filter.export');











Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
