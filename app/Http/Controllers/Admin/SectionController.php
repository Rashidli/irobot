<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    public function index()
    {

        $sections = Section::paginate(10);
        return view('admin.sections.index', compact('sections'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.sections.create');
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
            'image1'=>'nullable',
            'type'=>'required',
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

        Section::create([
            'image'=>  $filename,
            'image1'=>  $filename1 ?? null,
            'type'=>  $request->type,
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

        return redirect()->route('sections.index')->with('message','Section added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {

        return view('admin.sections.edit', compact('section'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Section $section)
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
            $section->image = $filename;

        }

        if($request->hasFile('image1')){

            $file = $request->file('image1');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $section->image1 = $filename;

        }

        $section->update( [

            'type'=> $request->type,
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

        return redirect()->back()->with('message','Section updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {

        $section->delete();

        return redirect()->route('sections.index')->with('message', 'Section deleted successfully');

    }
}
