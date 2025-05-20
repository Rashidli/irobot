<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppFaq;
use Illuminate\Http\Request;

class AppFaqController extends Controller
{

    public function index()
    {

        $app_faqs = AppFaq::query()->paginate(10);
        return view('admin.app_faqs.index', compact('app_faqs'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.app_faqs.create');
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
        ]);


        AppFaq::create([
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

        return redirect()->route('app_faqs.index')->with('message','AppFaq added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(AppFaq $app_faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppFaq $app_faq)
    {

        return view('admin.app_faqs.edit', compact('app_faq'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, AppFaq $app_faq)
    {
        $request->validate([
            'az_title'=>'required',
            'en_title'=>'nullable',
            'ru_title'=>'nullable',
            'az_description'=>'required',
            'en_description'=>'nullable',
            'ru_description'=>'nullable'
        ]);

        $app_faq->update( [

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

        return redirect()->back()->with('message','AppFaq updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppFaq $app_faq)
    {

        $app_faq->delete();
        return redirect()->route('app_faqs.index')->with('message', 'AppFaq deleted successfully');

    }
}
