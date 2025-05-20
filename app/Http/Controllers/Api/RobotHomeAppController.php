<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppFaqResource;
use App\Http\Resources\InstructionResource;
use App\Models\AppContent;
use App\Models\AppFaq;
use App\Models\AppMain;
use App\Models\Instruction;
use App\Models\MagicalWord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RobotHomeAppController extends Controller
{

    public function index() : JsonResponse
    {
        $app_faqs = AppFaq::query()->active()->get();
        $instructions = Instruction::query()->active()->get();
        $hero = AppMain::query()->active()->first();
        $second_section = AppContent::query()->active()->first();
        $magical_word = MagicalWord::query()->active()->first();
        return response()->json([
            'hero' => new InstructionResource($hero),
            'second_section' => new InstructionResource($second_section),
            'instructions' => InstructionResource::collection($instructions),
            'faqs' => AppFaqResource::collection($app_faqs),
            'magical_word' => new InstructionResource($magical_word),
        ], ResponseAlias::HTTP_OK);
    }

}
