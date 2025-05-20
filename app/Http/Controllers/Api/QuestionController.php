<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChoiceResource;
use App\Http\Resources\MainContentResource;
use App\Http\Resources\MainResource;
use App\Http\Resources\QuestionResource;
use App\Models\Choice;
use App\Models\Question;
use App\Models\QuestionMain;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class QuestionController extends Controller
{

    public function index(): JsonResponse
    {

        $question_main = QuestionMain::query()->active()->first();
        $questions = Question::query()->active()->with('sliders')->get();
        $choices = Choice::query()->active()->get();

        return response()->json(
            [
                'hero' => new MainContentResource($question_main),
                'questions' => QuestionResource::collection($questions),
                'choices' => ChoiceResource::collection($choices),
            ],
            ResponseAlias::HTTP_OK);

    }

}
