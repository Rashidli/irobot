<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeResource;
use App\Models\AccessoryType;
use App\Models\Type;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function productTypes() : JsonResponse
    {
        $types = Type::query()->active()->orderByDesc('id')->get();
        return response()->json(TypeResource::collection($types));
    }

    public function accessoryTypes() : JsonResponse
    {
        $types = AccessoryType::query()->active()->orderByDesc('id')->get();
        return response()->json(TypeResource::collection($types));
    }
}
