<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MagicalWord;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MagicalWordController extends Controller
{
    public function index()
    {

        $magical_words = MagicalWord::paginate(10);
        return view('admin.magical_words.index', compact('magical_words'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.magical_words.create');
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

        MagicalWord::create([
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

        return redirect()->route('magical_words.index')->with('message','MagicalWord added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(MagicalWord $magical_word)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MagicalWord $magical_word)
    {

        return view('admin.magical_words.edit', compact('magical_word'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, MagicalWord $magical_word)
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
            $magical_word->image = $filename;
        }

        $magical_word->update( [

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

        return redirect()->back()->with('message','MagicalWord updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MagicalWord $magical_word)
    {

        $magical_word->delete();

        return redirect()->route('magical_words.index')->with('message', 'MagicalWord deleted successfully');

    }
}
