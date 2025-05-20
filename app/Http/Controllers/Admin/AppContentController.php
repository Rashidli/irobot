<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppContent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppContentController extends Controller
{
    public function index()
    {

        $app_contents = AppContent::paginate(10);
        return view('admin.app_contents.index', compact('app_contents'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.app_contents.create');
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

        AppContent::create([
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

        return redirect()->route('app_contents.index')->with('message','AppContent added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(AppContent $app_content)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppContent $app_content)
    {

        return view('admin.app_contents.edit', compact('app_content'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, AppContent $app_content)
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
            $app_content->image = $filename;
        }

        $app_content->update( [

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

        return redirect()->back()->with('message','AppContent updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppContent $app_content)
    {

        $app_content->delete();

        return redirect()->route('app_contents.index')->with('message', 'AppContent deleted successfully');

    }
}
