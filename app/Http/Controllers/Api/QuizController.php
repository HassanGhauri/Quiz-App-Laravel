<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizController extends Controller
{
    // GET ALL QUIZZES
    public function index()
    {
        $quizzes = Quiz::all();

        return response()->json([
            'message' => 'Quizzes fetched successfully',
            'data' => $quizzes
        ]);
    }

    // GET SINGLE QUIZ
    public function show($id)
    {
        $quiz = Quiz::find($id);

        if (!$quiz) {
            return response()->json([
                'message' => 'Quiz not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Quiz fetched successfully',
            'data' => $quiz
        ]);
    }

    // CREATE QUIZ
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'total_time' => 'required|integer',
            'passing_marks' => 'required|integer'
        ]);

        $quiz = Quiz::create($validated);

        return response()->json([
            'message' => 'Quiz created successfully',
            'data' => $quiz
        ], 201);
    }

    // UPDATE QUIZ
    public function update(Request $request, $id)
    {
        $quiz = Quiz::find($id);

        if (!$quiz) {
            return response()->json([
                'message' => 'Quiz not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'total_time' => 'sometimes|integer',
            'passing_marks' => 'sometimes|integer'
        ]);

        $quiz->update($validated);

        return response()->json([
            'message' => 'Quiz updated successfully',
            'data' => $quiz
        ]);
    }

    // DELETE QUIZ
    public function delete($id)
    {
        $quiz = Quiz::find($id);

        if (!$quiz) {
            return response()->json([
                'message' => 'Quiz not found'
            ], 404);
        }

        $quiz->delete();

        return response()->json([
            'message' => 'Quiz deleted successfully'
        ]);
    }
}