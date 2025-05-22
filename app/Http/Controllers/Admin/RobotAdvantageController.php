<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RobotAdvantage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RobotAdvantageController extends Controller
{
    public function index()
    {

        $robot_advantages = RobotAdvantage::paginate(10);
        return view('admin.robot_advantages.index', compact('robot_advantages'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.robot_advantages.create');
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

        RobotAdvantage::create([
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

        return redirect()->route('robot_advantages.index')->with('message','RobotAdvantage added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(RobotAdvantage $robot_advantage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RobotAdvantage $robot_advantage)
    {

        return view('admin.robot_advantages.edit', compact('robot_advantage'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, RobotAdvantage $robot_advantage)
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
            $robot_advantage->image = $filename;
        }

        $robot_advantage->update( [

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

        return redirect()->back()->with('message','RobotAdvantage updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RobotAdvantage $robot_advantage)
    {

        $robot_advantage->delete();

        return redirect()->route('robot_advantages.index')->with('message', 'RobotAdvantage deleted successfully');

    }
}
