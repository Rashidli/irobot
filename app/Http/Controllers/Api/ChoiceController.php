<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChoiceResource;
use App\Models\Choice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ChoiceController extends Controller
{
    public function index(): JsonResponse
    {
        $choices = Choice::query()->active()->get();
        return response()->json(ChoiceResource::collection($choices), ResponseAlias::HTTP_OK);
    }
}
