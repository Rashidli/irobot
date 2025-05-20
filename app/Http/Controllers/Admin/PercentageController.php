<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Percentage;
use Illuminate\Http\Request;

class PercentageController extends Controller
{

    public function index()
    {

        $percentages = Percentage::query()->paginate(10);
        return view('admin.percentages.index', compact('percentages'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {

        return view('admin.percentages.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'month'=>'required',
            'percent'=>'required',
        ]);

        Percentage::create([
            'month'=>$request->month,
            'percent'=>$request->percent,
        ]);

        return redirect()->route('percentages.index')->with('message','Percentage added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Percentage $percentage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Percentage $percentage)
    {

        return view('admin.percentages.edit', compact('percentage'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Percentage $percentage)
    {

        $request->validate([
            'month'=>'required|numeric',
            'percent'=>'required|numeric',
        ]);

        $percentage->update( [

            'month'=>$request->month,
            'percent'=>$request->percent,

        ]);

        return redirect()->back()->with('message','Percentage updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Percentage $percentage)
    {

        $percentage->delete();
        return redirect()->route('percentages.index')->with('message', 'Percentage deleted successfully');

    }

}
