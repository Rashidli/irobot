<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SocialResource;
use App\Models\Social;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SocialController extends Controller
{

    public function index(): JsonResponse
    {
        $socials = Social::query()->active()->get();
        return response()->json(SocialResource::collection($socials), ResponseAlias::HTTP_OK);
    }

}
