<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessorySerie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccessorySerieController extends Controller
{
    public function index()
    {
        $accessory_series = AccessorySerie::query()->paginate(10);
        return view('admin.accessory_series.index', compact('accessory_series'));
    }

    public function create()
    {

        return view('admin.accessory_series.create');
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

        AccessorySerie::create([
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

        return redirect()->route('accessory_series.index')->with('message','AccessorySerie store successfully');

    }

    public function edit(AccessorySerie $accessory_series)
    {
        return view('admin.accessory_series.edit', compact('accessory_series'));
    }

    public function update(Request $request, AccessorySerie $accessory_series)
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
            $accessory_series->image = $filename;

        }

        $accessory_series->update( [

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
            ->with('message', 'AccessorySerie updated successfully');
    }


    public function destroy(AccessorySerie $accessory_serie)
    {
        $accessory_serie->delete();

        return redirect()->route('accessory_series.index')
            ->with('success', 'AccessorySerie deleted successfully.');
    }
}
