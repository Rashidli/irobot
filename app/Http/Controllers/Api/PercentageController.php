<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PercentageResource;
use App\Models\Percentage;
use App\Services\CalculateLoan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PercentageController extends Controller
{
    public function __construct(protected CalculateLoan $calculateLoan)
    {

    }

    public function index() : JsonResponse
    {

        $percentages = Percentage::all();
        return response()->json(PercentageResource::collection($percentages));

    }

    public function getPercentagePrice(Request $request) : JsonResponse
    {
        try {
            $request->validate([
                'price' => 'required',
                'percent' => 'required',
                'month' => 'required',
            ]);

            if($request->percent == 0){
                $price = round($request->price/$request->month,2);
            }else{
                $price = $this->calculateLoan->monthlyPayment($request->price, $request->month,$request->percent);
            }

            return response()->json($price);
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }

    }
}
