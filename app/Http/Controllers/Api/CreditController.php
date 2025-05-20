<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CreditItemResource;
use App\Http\Resources\CreditResource;
use App\Models\Credit;
use App\Models\CreditItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreditController extends Controller
{

    public function index() : JsonResponse
    {

        $credits = Credit::query()->with('credit_items','product')
            ->where('customer_id', auth()->user()->id)
            ->get();
        return response()->json(CreditResource::collection($credits));

    }

    public function creditDetail($id) : JsonResponse
    {

        $credit = Credit::query()->with('credit_items','product')
            ->where('customer_id', auth()->user()->id)
            ->findOrFail($id);

        return response()->json(new CreditResource($credit));

    }

}
