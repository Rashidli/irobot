<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Robot;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RobotController extends Controller
{
    public function index()
    {

        $robots = Robot::paginate(10);
        return view('admin.robots.index', compact('robots'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.robots.create');
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

        Robot::create([
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

        return redirect()->route('robots.index')->with('message','Robot added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Robot $robot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Robot $robot)
    {

        return view('admin.robots.edit', compact('robot'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Robot $robot)
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
            $robot->image = $filename;
        }

        $robot->update( [

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

        return redirect()->back()->with('message','Robot updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Robot $robot)
    {

        $robot->delete();

        return redirect()->route('robots.index')->with('message', 'Robot deleted successfully');

    }
}
