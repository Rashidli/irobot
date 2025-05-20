<?php

namespace App\Http\Controllers\Api;

use App\Enum\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Credit;
use App\Models\Customer;
use App\Models\Order;
use App\Services\CalculateLoan;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function __construct(protected CalculateLoan $calculateLoan)
    {

    }
    public function storeOrder(Request $request): JsonResponse
    {

        DB::beginTransaction();

        try {

            $customer = Customer::query()->findOrFail(auth()->user()->id);
            $basketItems = $customer->basketItems()->get();

            if ($basketItems->isEmpty()) {
                return response()->json(['message' => 'Basket is empty.'], 400);
            }

            $discountAmount = $request->discount;

            $finalPrice = $request->final_price;

            $order = $customer->orders()->create([
                'status' => OrderStatus::Ordered,
                'order_number' => strtoupper(uniqid('ORDER_')),
                'is_deliver' => $request->input('is_deliver', false),
                'shop' => $request->input('shop'),
                'payment_type' => $request->input('payment_type', 'cash'),
                'total_price' => $request->total_price,
                'discount' => $discountAmount,
                'delivered_price' => $request->delivered_price,
                'final_price' => $finalPrice,
                'address' => $request->input('address'),
                'additional_info' => $request->input('additional_info'),
            ]);

            foreach ($basketItems as $basketItem) {
                $order->order_items()->create([
                    'product_id' => $basketItem->product_id,
                    'quantity' => $basketItem->quantity,
                    'price' => $basketItem->price,
                ]);

                if ($basketItem->is_credit) {
                    $result = $this->calculateLoan->calculateLoan($basketItem->price, $basketItem->month, $basketItem->percent);

                    array_pop($result);

                    $credit = Credit::create([
                        'product_id' => $basketItem->product_id ?? null,
                        'price' => $basketItem->price ?? null,
                        'month' => $basketItem->month ?? null,
                        'percent' => $basketItem->percent ?? null,
                        'customer_id' => $basketItem->customer_id,
                        'monthly_payment' => $this->calculateLoan->monthlyPayment($basketItem->price, $basketItem->month, $basketItem->percent)
                    ]);

                    $date = \Carbon\Carbon::parse($order->created_at);

                    foreach ($result as $key => $res) {
                        $credit->credit_items()->create([
                            'date' => $date->addMonths(1),
                            'monthly_payment' => $res['monthly_payment'],
                            'remaining_amount' => $res['principal'],
                        ]);
                    }
                }
            }


            $customer->basketItems()->delete();

            DB::commit();

            return response()->json(['order' => new OrderResource($order)], 201);

        } catch (\Exception $exception) {

            DB::rollBack();

            \Log::error('Order creation failed', ['error' => $exception->getMessage()]);

            return response()->json(['error' => $exception->getMessage()], 500);

        }

    }

    public function getOrders(Request $request): JsonResponse
    {
        $status = $request->status;

        $customer = Customer::query()
            ->with(['orders' => function ($query) use ($status) {
                if ($status) {
                    $query->where('status', $status);
                }
                $query->with('order_items')->withCount('order_items');
            }])
            ->findOrFail(auth()->user()->id);

        return response()->json(OrderResource::collection($customer->orders));
    }


    public function getOrderItem($id) : JsonResponse
    {

        try {
            $order = Order::query()->with('order_items')->withCount('order_items')->findOrFail($id);
            return response()->json(new OrderResource($order));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Order not found.',
                'status' => 404
            ], 404);
        }

    }

    public function cancelOrder(Request $request) : JsonResponse
    {
        $request->validate([
            'order_id'      => 'required|exists:orders,id',
            'cancel_reason' => 'nullable|string|max:255',
            'cancel_note'   => 'nullable|string',
        ]);

        $order = Order::find($request->order_id);

        if ($order->status === 'cancelled') {
            return response()->json(['message' => 'Order is already canceled.'], 400);
        }

        $order->status = 'cancelled'; // Assuming this is the cancellation status
        $order->cancel_reason = $request->cancel_reason;
        $order->cancel_note = $request->cancel_note;
        $order->save();

        return response()->json(['message' => 'Order canceled successfully.']);
    }

    public function changeOrderAddress(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'address' => 'required|string',
            'additional_info' => 'nullable|string'
        ]);

        $order = Order::findOrFail($validated['order_id']);

        $order->address = $validated['address'];

        if (isset($validated['additional_info'])) {
            $order->additional_info = $validated['additional_info'];
        }

        $order->save();

        return response()->json([
            'message' => 'Address changed successfully.',
            'order' => $order->only(['id', 'address', 'additional_info'])
        ]);
    }

}
