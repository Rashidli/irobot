<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvantageResource;
use App\Http\Resources\ChoiceResource;
use App\Http\Resources\InstructionResource;
use App\Http\Resources\SupportResource;
use App\Models\Advantage;
use App\Models\Choice;
use App\Models\RobotMain;
use App\Models\Support;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class WhyRobotController extends Controller
{

    public function index() : JsonResponse
    {

        $robot_main = RobotMain::query()->active()->first();
        $choices = Choice::query()->active()->get();
        $supports = Support::query()->active()->get();
        $advantages = Advantage::query()->active()->get();

        return response()->json([
            'hero' => new InstructionResource($robot_main),
            'choices' => ChoiceResource::collection($choices),
            'supports' => SupportResource::collection($supports),
            'advantages' => AdvantageResource::collection($advantages),
        ], ResponseAlias::HTTP_OK);

    }

}
