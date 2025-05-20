<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessoryType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccessoryTypeController extends Controller
{
    public function index()
    {

        $accessory_types = AccessoryType::paginate(10);
        return view('admin.accessory_types.index', compact('accessory_types'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.accessory_types.create');
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
            'az_description'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
            'image'=>'required',
            'image1'=>'required',
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }

        if($request->hasFile('image1')){
            $file = $request->file('image1');
            $filename1 = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename1);
        }

        AccessoryType::create([
            'image'=>  $filename,
            'image1'=>  $filename1,
            'az'=>[
                'title'=>$request->az_title,
                'description'=>$request->az_description,
            ],
            'en'=>[
                'title'=>$request->en_title,
                'description'=>$request->en_description,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'description'=>$request->ru_description,
            ]
        ]);

        return redirect()->route('accessory_types.index')->with('message','AccessoryType added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(AccessoryType $accessory_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccessoryType $accessory_type)
    {

        return view('admin.accessory_types.edit', compact('accessory_type'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, AccessoryType $accessory_type)
    {
        $request->validate([
            'az_title'=>'required',
            'en_title'=>'required',
            'ru_title'=>'required',
            'az_description'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
        ]);

        if($request->hasFile('image')){

            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $accessory_type->image = $filename;
        }

        if($request->hasFile('image1')){

            $file = $request->file('image1');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $accessory_type->image1 = $filename;
        }

        $accessory_type->update( [

            'is_active'=> $request->is_active,
            'az'=>[
                'title'=>$request->az_title,
                'description'=>$request->az_description,
            ],
            'en'=>[
                'title'=>$request->en_title,
                'description'=>$request->en_description,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'description'=>$request->ru_description,
            ]

        ]);

        return redirect()->back()->with('message','AccessoryType updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccessoryType $accessory_type)
    {

        $accessory_type->delete();

        return redirect()->route('accessory_types.index')->with('message', 'AccessoryType deleted successfully');

    }
}
