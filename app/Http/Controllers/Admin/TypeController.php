<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TypeController extends Controller
{

    public function index()
    {

        $types = Type::paginate(10);
        return view('admin.types.index', compact('types'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.types.create');
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

        Type::create([
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

        return redirect()->route('types.index')->with('message','Type added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {

        return view('admin.types.edit', compact('type'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Type $type)
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
            $type->image = $filename;
        }

        if($request->hasFile('image1')){

            $file = $request->file('image1');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $type->image1 = $filename;
        }

        $type->update( [

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

        return redirect()->back()->with('message','Type updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {

        $type->delete();

        return redirect()->route('types.index')->with('message', 'Type deleted successfully');

    }
}
