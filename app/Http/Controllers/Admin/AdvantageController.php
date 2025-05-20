<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advantage;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class AdvantageController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {

    }
    public function index()
    {

        $advantages = Advantage::paginate(10);
        return view('admin.advantages.index', compact('advantages'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.advantages.create');
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
            'image'=>'required',
        ]);

        if($request->hasFile('image')){
            $filename = $this->imageUploadService->upload($request->file('image'));
        }

        Advantage::create([
            'image'=>  $filename,
            'az'=>[
                'title'=>$request->az_title,
            ],
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('advantages.index')->with('message','Advantage added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Advantage $advantage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advantage $advantage)
    {

        return view('admin.advantages.edit', compact('advantage'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Advantage $advantage)
    {
        $request->validate([
            'az_title'=>'required',
            'en_title'=>'nullable',
            'ru_title'=>'nullable',
            'image' => 'nullable'
        ]);

        if($request->hasFile('image')){
            $advantage->image = $this->imageUploadService->upload($request->file('image'));
        }

        $advantage->update( [

            'is_active'=> $request->is_active,
            'az'=>[
                'title'=>$request->az_title,
            ],
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);

        return redirect()->back()->with('message','Advantage updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advantage $advantage)
    {

        $advantage->delete();

        return redirect()->route('advantages.index')->with('message', 'Advantage deleted successfully');

    }
}
