<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserResult;
use App\Models\User;
use App\Models\Quiz;

class UserResultController extends Controller
{
    // GET ALL RESULTS
    public function index()
    {
        $results = UserResult::with(['user', 'quiz'])->get();

        return response()->json([
            'message' => 'Results fetched successfully',
            'data' => $results
        ]);
    }

    // GET SINGLE RESULT
    public function show($id)
    {
        $result = UserResult::with(['user', 'quiz'])->find($id);

        if (!$result) {
            return response()->json([
                'message' => 'Result not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Result fetched successfully',
            'data' => $result
        ]);
    }

    // CREATE RESULT
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',

            'quiz_id' => 'required|exists:quizzes,id',

            'answers' => 'required|array|min:1',

            'answers.*.question_id' => 'required|integer',

            'answers.*.question' => 'required|string',

            'answers.*.correct' => 'required|boolean',

            'percentage' => 'required|numeric|min:0|max:100',

            'passed' => 'required|boolean',

            'time_taken' => 'required|integer|min:0',
        ]);

        $result = UserResult::create($validated);

        return response()->json([
            'message' => 'Result created successfully',
            'data' => $result
        ], 201);
    }

    // UPDATE RESULT
    public function update(Request $request, $id)
    {
        $result = UserResult::find($id);

        if (!$result) {
            return response()->json([
                'message' => 'Result not found'
            ], 404);
        }

        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',

            'quiz_id' => 'sometimes|exists:quizzes,id',

            'answers' => 'sometimes|array|min:1',

            'answers.*.question_id' => 'required_with:answers|integer',

            'answers.*.question' => 'required_with:answers|string',

            'answers.*.correct' => 'required_with:answers|boolean',

            'percentage' => 'sometimes|numeric|min:0|max:100',

            'passed' => 'sometimes|boolean',

            'time_taken' => 'sometimes|integer|min:0',
        ]);

        $result->update($validated);

        return response()->json([
            'message' => 'Result updated successfully',
            'data' => $result
        ]);
    }

    // DELETE RESULT
    public function delete($id)
    {
        $result = UserResult::find($id);

        if (!$result) {
            return response()->json([
                'message' => 'Result not found'
            ], 404);
        }

        $result->delete();

        return response()->json([
            'message' => 'Result deleted successfully'
        ]);
    }
}