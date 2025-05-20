<?php

namespace App\Http\Controllers\Admin;

use App\Enum\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()->with('customer')->orderByDesc('id');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('shop')) {
            $query->where('shop', $request->shop);
        }

        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        $orders = $query->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {

        $order = Order::query()->with('order_items')->findOrFail($id);
        $orderItems = $order->order_items()->get();
        return view('admin.orders.show', compact('orderItems','order'));

    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(array_column(OrderStatus::cases(), 'value'))],
        ]);

        $order = Order::query()->findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('message', 'Sifariş statusu uğurla dəyişdirildi!');
    }

    public function cancelOrder(Request $request, $orderId)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $order = Order::findOrFail($orderId);

        // Check if the order belongs to the authenticated user (customer)
        if ($order->customer_id !== auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Check if the order is already canceled or delivered
        if ($order->status === OrderStatus::Cancelled->value) {
            return response()->json(['message' => 'Order already canceled'], 400);
        }

        // Change order status to 'Cancelled' and store the reason
        $order->update([
            'status' => OrderStatus::Cancelled->value,
            'cancel_reason' => $request->reason,
        ]);

        return response()->json(['message' => 'Order canceled successfully']);
    }
}
