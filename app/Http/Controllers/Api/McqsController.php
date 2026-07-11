<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mcq;
use App\Models\Quiz;

class McqsController extends Controller
{
    // GET ALL MCQS
    public function index()
    {
        $mcqs = Mcq::with('quiz')->get();

        return response()->json([
            'message' => 'MCQs fetched successfully',
            'data' => $mcqs
        ]);
    }

    public function getQuizMcqs($id)
{
    $quiz = Quiz::find($id);

    if (!$quiz) {
        return response()->json([
            'message' => 'Quiz not found'
        ], 404);
    }

    $mcqs = Mcq::where('quiz_id', $id)
        ->where('enable', true)
        ->get();

    return response()->json([
        'message' => 'Quiz MCQs fetched successfully',
        'quiz' => $quiz,
        'data' => $mcqs
    ]);
}

    // GET SINGLE MCQ
    public function show($id)
    {
        $mcq = Mcq::with('quiz')->find($id);

        if (!$mcq) {
            return response()->json([
                'message' => 'MCQ not found'
            ], 404);
        }

        return response()->json([
            'message' => 'MCQ fetched successfully',
            'data' => $mcq
        ]);
    }

    // CREATE MCQ
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',

            'choices' => 'required|array|min:2',

            'choices.*.choice' => 'required|string',

            'choices.*.is_correct' => 'required|boolean',
            'enable' => 'required|boolean',
        ]);

        // Ensure only one correct answer exists
        $correctAnswers = collect($validated['choices'])
            ->where('is_correct', true)
            ->count();

        if ($correctAnswers !== 1) {
            return response()->json([
                'message' => 'Exactly one choice must be correct'
            ], 422);
        }

        $mcq = Mcq::create($validated);

        return response()->json([
            'message' => 'MCQ created successfully',
            'data' => $mcq
        ], 201);
    }

    // UPDATE MCQ
    public function update(Request $request, $id)
    {
        $mcq = Mcq::find($id);

        if (!$mcq) {
            return response()->json([
                'message' => 'MCQ not found'
            ], 404);
        }

        $validated = $request->validate([
            'quiz_id' => 'sometimes|exists:quizzes,id',

            'question' => 'sometimes|string',

            'choices' => 'sometimes|array|min:2',

            'choices.*.choice' => 'required_with:choices|string',

            'choices.*.is_correct' => 'required_with:choices|boolean',
        ]);

        // Validate correct answer count if choices are updated
        if (isset($validated['choices'])) {

            $correctAnswers = collect($validated['choices'])
                ->where('is_correct', true)
                ->count();

            if ($correctAnswers !== 1) {
                return response()->json([
                    'message' => 'Exactly one choice must be correct'
                ], 422);
            }
        }

        $mcq->update($validated);

        return response()->json([
            'message' => 'MCQ updated successfully',
            'data' => $mcq
        ]);
    }

    // DELETE MCQ
    public function delete($id)
    {
        $mcq = Mcq::find($id);

        if (!$mcq) {
            return response()->json([
                'message' => 'MCQ not found'
            ], 404);
        }

        $mcq->delete();

        return response()->json([
            'message' => 'MCQ deleted successfully'
        ]);
    }
}