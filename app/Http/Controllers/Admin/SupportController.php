<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Support;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class SupportController extends Controller
{

    public function __construct(protected ImageUploadService $imageUploadService)
    {

    }
    public function index()
    {

        $supports = Support::paginate(10);
        return view('admin.supports.index', compact('supports'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.supports.create');
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

        Support::create([
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

        return redirect()->route('supports.index')->with('message','Support added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Support $support)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Support $support)
    {

        return view('admin.supports.edit', compact('support'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Support $support)
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
            $support->image = $this->imageUploadService->upload($request->file('image'));
        }

        $support->update( [

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

        return redirect()->back()->with('message','Support updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Support $support)
    {

        $support->delete();

        return redirect()->route('supports.index')->with('message', 'Support deleted successfully');

    }

}
