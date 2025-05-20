<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\AccessoryCategory;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function productCategories() : JsonResponse
    {
        $categories = Category::query()->orderByDesc('id')->get();
        return response()->json(CategoryResource::collection($categories));
    }

    public function accessoryCategories() : JsonResponse
    {
        $categories = AccessoryCategory::query()->orderByDesc('id')->get();
        return response()->json(CategoryResource::collection($categories));
    }
}
