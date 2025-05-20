<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionMain;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionMainController extends Controller
{
    public function index()
    {

        $question_mains = QuestionMain::paginate(10);
        return view('admin.question_mains.index', compact('question_mains'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.question_mains.create');
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

        QuestionMain::create([
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

        return redirect()->route('question_mains.index')->with('message','QuestionMain added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionMain $question_main)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuestionMain $question_main)
    {

        return view('admin.question_mains.edit', compact('question_main'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, QuestionMain $question_main)
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
            $question_main->image = $filename;
        }

        $question_main->update( [

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

        return redirect()->back()->with('message','QuestionMain updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionMain $question_main)
    {

        $question_main->delete();

        return redirect()->route('question_mains.index')->with('message', 'QuestionMain deleted successfully');

    }
}
