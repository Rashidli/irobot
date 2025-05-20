<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BasketItemResource;
use App\Models\BasketItem;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BasketItemController extends Controller
{

    public function index(): JsonResponse
    {

        $customer = Customer::query()->findOrFail(auth()->user()->id);
        $items = $customer->basketItems()->with('product')->get();

        $delivered_price = $items->isNotEmpty() ? 5 : 0;

        $totalPrice = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $productPriceSum = $items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $discount = round($productPriceSum - $totalPrice, 2);

        return response()->json([
            'basket_items' => BasketItemResource::collection($items),
            'total_price' => round($totalPrice + $discount, 2),
            'discount' => $discount,
            'delivered_price' => $delivered_price,
            'final_price' => round($totalPrice + $delivered_price, 2)
        ]);

    }

    public function store(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $customer = Customer::query()->findOrFail(auth()->user()->id);

        $item = $customer->basketItems()->updateOrCreate(
            ['product_id' => $validated['product_id']],
            ['quantity' => $validated['quantity'], 'price' => $validated['price']]
        );

        return response()->json(new BasketItemResource($item), 201);

    }


    public function update(BasketItem $basketItem, Request $request): JsonResponse
    {

        $request->validate([
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'is_credit' => 'nullable',
            'percent' => 'nullable',
            'month' => 'nullable',
            'monthly_payment' => 'nullable'
        ]);

        $basketItem->update([
            'quantity' => $request->quantity,
            'price' => $request->price,
            'is_credit' => $request->is_credit,
            'percent' => $request->percent,
            'month' => $request->month,
            'monthly_payment' => $request->monthly_payment,
        ]);

        return response()->json(new BasketItemResource($basketItem), 200);

    }

    public function multipleUpdate(Request $request): JsonResponse
    {

        $request->validate([
            'basket_items' => 'array'
        ]);

        foreach ($request->basket_items as $basket_item) {

            $basket = BasketItem::query()->findOrFail($basket_item['basket_id']);

            $basket->update([
                'is_credit' => $basket_item['is_credit'] ?? null,
                'percent' => $basket_item['percent'] ?? null,
                'month' => $basket_item['month'] ?? null,
                'monthly_payment' => $basket_item['monthly_payment'] ?? null,
            ]);

        }

        return response()->json(['message' => 'Successfully updated']);

    }

    public function destroy(BasketItem $basketItem) : JsonResponse
    {

        $basketItem->delete();
        return response()->json(['message' => 'Item removed']);

    }

}
