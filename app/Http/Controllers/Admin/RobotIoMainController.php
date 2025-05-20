<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RobotIoMain;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RobotIoMainController extends Controller
{
    public function index()
    {

        $robot_io_mains = RobotIoMain::paginate(10);
        return view('admin.robot_io_mains.index', compact('robot_io_mains'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.robot_io_mains.create');
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

        RobotIoMain::create([
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

        return redirect()->route('robot_io_mains.index')->with('message','RobotIoMain added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(RobotIoMain $robot_io_main)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RobotIoMain $robot_io_main)
    {

        return view('admin.robot_io_mains.edit', compact('robot_io_main'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, RobotIoMain $robot_io_main)
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
            $robot_io_main->image = $filename;
        }

        $robot_io_main->update( [

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

        return redirect()->back()->with('message','RobotIoMain updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RobotIoMain $robot_io_main)
    {

        $robot_io_main->delete();

        return redirect()->route('robot_io_mains.index')->with('message', 'RobotIoMain deleted successfully');

    }
}
