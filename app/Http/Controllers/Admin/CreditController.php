<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\CreditItem;
use App\Services\CalculateLoan;
use Illuminate\Http\Request;

class CreditController extends Controller
{

    public function __construct(protected CalculateLoan $calculateLoan)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $credits = Credit::query()->with('customer', 'product','credit_items')->paginate(30);
        return view('admin.credits.index', compact('credits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $product_id = 1;
        $price = 3900;
        $month = 24;
        $percent = 29;

        Credit::create([
            'product_id' => $product_id,
            'price'  => $price,
            'month' => $month,
            'percent' => $percent
        ]);

        $data = $this->calculateLoan->calculateLoan($percent,$month,$percent);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Credit $credit)
    {
        $credit_items = $credit->credit_items()->get();
        return view('admin.credits.show', compact('credit_items'));
    }

    public function toggleStatus($id)
    {
        $credit_item = CreditItem::query()->findOrFail($id);
        $credit_item->status = !$credit_item->status;
        $credit_item->save();
        return redirect()->back()->with('message', 'Status uğurla dəyişdirildi');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Credit $credit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Credit $credit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Credit $credit)
    {
        //
    }
}
