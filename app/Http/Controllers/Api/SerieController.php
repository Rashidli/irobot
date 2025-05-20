<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SerieResource;
use App\Models\AccessorySerie;
use App\Models\ProductSerie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function productSeries() : JsonResponse
    {
        $series = ProductSerie::query()->orderByDesc('id')->get();
        return response()->json(SerieResource::collection($series));
    }

    public function accessorySeries() : JsonResponse
    {
        $series = AccessorySerie::query()->orderByDesc('id')->get();
        return response()->json(SerieResource::collection($series));
    }
}
