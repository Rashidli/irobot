<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupportResource;
use App\Models\Support;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SupportController extends Controller
{
    public function index(): JsonResponse
    {
        $supports = Support::query()->active()->get();
        return response()->json(SupportResource::collection($supports), ResponseAlias::HTTP_OK);
    }
}
