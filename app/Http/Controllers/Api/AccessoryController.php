<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccessoryResource;
use App\Http\Resources\AccessorySingleResource;
use App\Models\Accessory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AccessoryController extends Controller
{

    public function index(Request $request): JsonResponse
    {

        $query = Accessory::query()->active();

        $query->when($request->filled('accessory_category_id'), fn($q) => $q->where('accessory_category_id', $request->accessory_category_id))
            ->when($request->filled('accessory_serie_id'), fn($q) => $q->where('accessory_serie_id', $request->product_serie_id))
            ->when($request->filled('accessory_type_id'), fn($q) => $q->where('accessory_type_id', $request->accessory_type_id))
            ->when($request->filled('room_area'), fn($q) => $q->where('room_area', '>=', $request->room_area))
            ->when($request->filled('min_price'), fn($q) => $q->where('price', '>=', $request->min_price))
            ->when($request->filled('max_price'), fn($q) => $q->where('price', '<=', $request->max_price))
            ->when($request->filled('is_discounted'), fn($q) => $q->whereNotNull('discounted_price'))
            ->when($request->filled('title'), fn($q) => $q->whereTranslationLike('title', '%' . $request->title . '%'));

        $accessories = $query->paginate(12);

        return response()->json([
            'data' => AccessoryResource::collection($accessories),
            'count' => $accessories->count(),
            'meta' => [
                'current_page' => $accessories->currentPage(),
                'last_page' => $accessories->lastPage(),
                'per_page' => $accessories->perPage(),
                'total' => $accessories->total(),
            ],
        ]);

    }

    public function accessorySingle($slug): JsonResponse
    {

        $accessory = Accessory::query()->with('sliders')
            ->whereHas('translation', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })->first();
        return response()->json(new AccessorySingleResource($accessory));

    }

}
