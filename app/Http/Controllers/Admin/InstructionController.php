<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instruction;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class InstructionController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {

    }
    public function index()
    {

        $instructions = Instruction::paginate(10);
        return view('admin.instructions.index', compact('instructions'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.instructions.create');
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

        Instruction::create([
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

        return redirect()->route('instructions.index')->with('message','Instruction added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Instruction $instruction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instruction $instruction)
    {

        return view('admin.instructions.edit', compact('instruction'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Instruction $instruction)
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
            $instruction->image = $this->imageUploadService->upload($request->file('image'));
        }

        $instruction->update( [

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

        return redirect()->back()->with('message','Instruction updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instruction $instruction)
    {

        $instruction->delete();

        return redirect()->route('instructions.index')->with('message', 'Instruction deleted successfully');

    }
}
