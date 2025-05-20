<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {

        $shops = Shop::paginate(10);
        return view('admin.shops.index', compact('shops'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {

        return view('admin.shops.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'az_title'=>'required',
            'en_title'=>'required',
            'ru_title'=>'required',
            'az_address'=>'required',
            'en_address'=>'required',
            'ru_address'=>'required',
        ]);

        Shop::create([
            'az'=>[
                'title'=>$request->az_title,
                'address'=>$request->az_address,
            ],
            'en'=>[
                'title'=>$request->en_title,
                'address'=>$request->en_address,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'address'=>$request->ru_address,
            ]
        ]);

        return redirect()->route('shops.index')->with('message','Shop added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        return view('admin.shops.edit', compact('shop'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Shop $shop)
    {

        $request->validate([
            'az_title'=>'required',
            'en_title'=>'required',
            'ru_title'=>'required',
            'az_address'=>'required',
            'en_address'=>'required',
            'ru_address'=>'required',
        ]);

        $shop->update([

            'is_active'=> $request->is_active,
            'az'=>[
                'title'=>$request->az_title,
                'address'=>$request->az_address,
            ],
            'en'=>[
                'title'=>$request->en_title,
                'address'=>$request->en_address,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'address'=>$request->ru_address,
            ]

        ]);

        return redirect()->back()->with('message','Shop updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {

        $shop->delete();
        return redirect()->route('shops.index')->with('message', 'Shop deleted successfully');

    }

}
