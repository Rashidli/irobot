<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {

    }
    public function index()
    {

        $choices = Choice::paginate(10);
        return view('admin.choices.index', compact('choices'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.choices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'az_title'=>'required',
            'en_title'=>'nullable',
            'ru_title'=>'nullable',
            'az_description'=>'required',
            'en_description'=>'nullable',
            'ru_description'=>'nullable',
            'image'=>'required',
        ]);

        if($request->hasFile('image')){
            $filename = $this->imageUploadService->upload($request->file('image'));
        }

        Choice::create([
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

        return redirect()->route('choices.index')->with('message','Choice added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Choice $choice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Choice $choice)
    {

        return view('admin.choices.edit', compact('choice'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Choice $choice)
    {
        $request->validate([
            'az_title'=>'required',
            'en_title'=>'nullable',
            'ru_title'=>'nullable',
            'az_description'=>'required',
            'en_description'=>'nullable',
            'ru_description'=>'nullable',
            'image' => 'nullable'
        ]);

        if($request->hasFile('image')){
            $choice->image = $this->imageUploadService->upload($request->file('image'));
        }

        $choice->update( [

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

        return redirect()->back()->with('message','Choice updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Choice $choice)
    {

        $choice->delete();

        return redirect()->route('choices.index')->with('message', 'Choice deleted successfully');

    }
}
