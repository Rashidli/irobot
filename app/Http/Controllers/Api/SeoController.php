<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SeoResource;
use App\Models\Single;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        $single =  Single::query()->where('type', $request->type)->first();
        return response()->json(new SeoResource($single));
    }
}
