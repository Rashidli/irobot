<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstructionResource;
use App\Models\Instruction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class InstructionController extends Controller
{

    public function index(): JsonResponse
    {
        $instructions = Instruction::query()->active()->get();
        return response()->json(InstructionResource::collection($instructions), ResponseAlias::HTTP_OK);
    }

}
