<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDifferentResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSingleResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request): JsonResponse
    {

        $query = Product::query()->active();

        $query->when($request->filled('category_id'), fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->filled('product_serie_id'), fn($q) => $q->where('product_serie_id', $request->product_serie_id))
            ->when($request->filled('type_id'), fn($q) => $q->where('type_id', $request->type_id))
            ->when($request->filled('room_area'), fn($q) => $q->where('room_area', '>=', (int) $request->room_area))
            ->when($request->filled('min_price'), fn($q) => $q->where('price', '>=', (float) $request->min_price))
            ->when($request->filled('max_price'), fn($q) => $q->where('price', '<=',(float) $request->max_price))
            ->when($request->filled('is_new'), fn($q) => $q->where('is_new', $request->is_new))
            ->when($request->filled('is_paket'), fn($q) => $q->where('is_paket', $request->is_paket))
            ->when($request->filled('is_discounted'), fn($q) => $q->whereNotNull('discounted_price'))
            ->when($request->filled('is_bestseller'), fn($q) => $q->where('is_bestseller', $request->is_bestseller))
            ->when($request->filled('title'), fn($q) => $q->whereTranslationLike('title', '%' . $request->title . '%'));

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'A-Z':
                    $query->orderByTranslation('title','ASC');
                    break;
                case 'Z-A':
                    $query->orderByTranslation('title','DESC');
                    break;
                case 'expensive-cheap':
                    $query->orderBy('price', 'desc');
                    break;
                case 'cheap-expensive':
                    $query->orderBy('price', 'asc');
                    break;
                case 'old-new':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'new-old':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    break;
            }
        }

        $products = $query->paginate(12);

        return response()->json([
            'data' => ProductResource::collection($products),
            'count' => $products->total(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);

    }

    public function productSingle($slug): JsonResponse
    {

        try {
            $product = Product::query()->with(
                'sliders','comments', 'product_faqs', 'product_details', 'product_colors', 'product_features','accessories'
            )
                ->whereHas('translation', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                })->first();
            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }
            return response()->json(new ProductSingleResource($product));
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }

    }

    public function chooseProducts(Request $request): JsonResponse
    {

        $mess_coming = $request->mess_coming; // 'parent','animals','children'
        $floor_home = $request->floor_home; // 1,2,3
        $level_clutter = $request->level_clutter; // 1,2,3

        $products = Product::query()
            ->when($mess_coming, function ($query, $mess_coming) {
                return $query->where('mess_coming', $mess_coming);
            })
            ->when($floor_home, function ($query, $floor_home) {
                return $query->where('floor_home', $floor_home);
            })
            ->when($level_clutter, function ($query, $level_clutter) {
                return $query->where('level_clutter', $level_clutter);
            })
            ->get();

        return response()->json(ProductResource::collection($products));

    }

    public function getProducts(Request $request) : JsonResponse
    {

        $product_ids = $request->product_ids ?? [];
        $products = Product::query()->whereIn('id', $product_ids)->get();

        return response()->json(ProductResource::collection($products));

    }

    public function getDifferentProducts(Request $request): JsonResponse
    {
        $raw_ids = $request->input('product_ids', []);

        // ["1,2,3"] tipini [1,2,3] şəklinə çevirmək
        $product_ids = collect($raw_ids)
            ->flatMap(fn($value) => explode(',', $value))
            ->map(fn($id) => (int) $id)
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (empty($product_ids)) {
            return response()->json([]);
        }

        $products = Product::whereIn('id', $product_ids)->get();

        return response()->json(ProductDifferentResource::collection($products));
    }



}
