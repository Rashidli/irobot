<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSerie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductSerieController extends Controller
{
    public function index()
    {
        $product_series = ProductSerie::query()->paginate(10);
        return view('admin.product_series.index', compact('product_series'));
    }

    public function create()
    {

        return view('admin.product_series.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
            'az_title' => 'required|string|max:255',
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }

        ProductSerie::create([
            'image' => $filename ?? null,
            'az'=>[
                'title'=>$request->az_title,
            ],
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('product_series.index')->with('message','ProductSerie store successfully');
    }

    public function edit(ProductSerie $product_series)
    {
        return view('admin.product_series.edit', compact('product_series' ));
    }

    public function update(Request $request, ProductSerie $product_series)
    {
        $request->validate([
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
            'az_title' => 'required|string|max:255',
        ]);

        if($request->hasFile('image')){

            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $product_series->image = $filename;
        }

        $product_series->update( [

            'az'=>[
                'title'=>$request->az_title,
            ],
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);

        return redirect()->back()
            ->with('message', 'ProductSerie updated successfully');
    }


    public function destroy(ProductSerie $product_serie)
    {
        $product_serie->delete();

        return redirect()->route('product_series.index')
            ->with('success', 'ProductSerie deleted successfully.');
    }
}
