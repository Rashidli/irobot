<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use App\Services\ApiResponseBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct(protected ApiResponseBuilder $apiResponseBuilder){}

    public function index()
    {
        $shops = Shop::active()->get();

        return $this->apiResponseBuilder
            ->setStatus(true)
            ->setMessage('Mağazalar uğurla çəkildi.')
            ->setData(ShopResource::collection($shops))
            ->build();
    }

}
