<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppMain;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppMainController extends Controller
{
    public function index()
    {

        $app_mains = AppMain::paginate(10);
        return view('admin.app_mains.index', compact('app_mains'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.app_mains.create');
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
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }

        AppMain::create([
            'image'=>  $filename,
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

        return redirect()->route('app_mains.index')->with('message','AppMain added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(AppMain $app_main)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppMain $app_main)
    {

        return view('admin.app_mains.edit', compact('app_main'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, AppMain $app_main)
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
            $app_main->image = $filename;
        }

        $app_main->update( [

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

        return redirect()->back()->with('message','AppMain updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppMain $app_main)
    {

        $app_main->delete();

        return redirect()->route('app_mains.index')->with('message', 'AppMain deleted successfully');

    }
}
