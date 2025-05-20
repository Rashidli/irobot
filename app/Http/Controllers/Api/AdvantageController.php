<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvantageResource;
use App\Models\Advantage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AdvantageController extends Controller
{
    public function index(): JsonResponse
    {
        $advantages = Advantage::query()->active()->get();
        return response()->json(AdvantageResource::collection($advantages), ResponseAlias::HTTP_OK);
    }
}
