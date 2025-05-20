<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppFaqResource;
use App\Models\AppFaq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AppFaqController extends Controller
{
    public function index(): JsonResponse
    {

        $app_faqs = AppFaq::query()->active()->get();
        return response()->json(AppFaqResource::collection($app_faqs), ResponseAlias::HTTP_OK);

    }
}
