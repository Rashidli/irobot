<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MapResource;
use App\Models\Map;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MapController extends Controller
{

    public function index(): JsonResponse
    {

        $map = Map::query()->active()->first();
        return response()->json(new MapResource($map), ResponseAlias::HTTP_OK);

    }

}
