<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Special;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class SpecialController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {

    }

    public function index()
    {

        $specials = Special::query()->paginate(10);
        return view('admin.specials.index', compact('specials'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.specials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'az_title'=>'required',
                'en_title'=>'required',
                'ru_title'=>'required',
                'az_description'=>'required',
                'en_description'=>'required',
                'ru_description'=>'required',
                'image'=>'required',
                'image1'=>'required',
            ]);

            if($request->hasFile('image')){
                $filename = $this->imageUploadService->upload($request->file('image'));
            }

            if($request->hasFile('image1')){
                $filename1 = $this->imageUploadService->upload($request->file('image1'));
            }

            Special::create([
                'image'=>  $filename,
                'image1'=>  $filename1,
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

        }catch (\Exception $exception){
            return $exception->getMessage();
        }

        return redirect()->route('specials.index')->with('message','Special added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Special $special)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Special $special)
    {
        $products = Product::query()->active()->get();
        return view('admin.specials.edit', compact('special','products'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Special $special)
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
            $special->image = $this->imageUploadService->upload($request->file('image'));
        }

        if($request->hasFile('image1')){
            $special->image1 = $this->imageUploadService->upload($request->file('image1'));
        }

        $special->update( [

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

        if($request->products){
            $special->products()->sync($request->products);
        }

        return redirect()->back()->with('message','Special updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Special $special)
    {

        $special->delete();

        return redirect()->route('specials.index')->with('message', 'Special deleted successfully');

    }
}
