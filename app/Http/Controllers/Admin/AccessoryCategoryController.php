<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessoryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccessoryCategoryController extends Controller
{

    public function index()
    {
        $accessory_categories = AccessoryCategory::query()->paginate(10);
        return view('admin.accessory_categories.index', compact('accessory_categories'));
    }

    public function create()
    {

        return view('admin.accessory_categories.create');
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

        AccessoryCategory::create([
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

        return redirect()->route('accessory_categories.index')->with('message','AccessoryCategory store successfully');
    }

    public function edit(AccessoryCategory $accessory_category)
    {

        return view('admin.accessory_categories.edit', compact('accessory_category' ));
    }

    public function update(Request $request, AccessoryCategory $accessory_category)
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
            $accessory_category->image = $filename;
        }

        $accessory_category->update( [

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
            ->with('message', 'AccessoryCategory updated successfully');
    }


    public function destroy(AccessoryCategory $accessory_category)
    {
        $accessory_category->delete();

        return redirect()->route('accessory_categories.index')
            ->with('success', 'AccessoryCategory deleted successfully.');
    }

}
