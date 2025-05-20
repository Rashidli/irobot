<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{

    public function __construct(protected ImageUploadService $imageUploadService)
    {

    }

    public function index()
    {

        $questions = Question::paginate(10);
        return view('admin.questions.index', compact('questions'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.questions.create');
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
        ]);

        $question = Question::create([
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

        if ($request->hasFile('sliders')) {
            foreach ($request->file('sliders') as $image) {
                $question->sliders()->create([
                    'image' => $this->imageUploadService->upload($image)
                ]);
            }
        }

        return redirect()->route('questions.index')->with('message','Question added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {

        return view('admin.questions.edit', compact('question'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'az_title'=>'required',
            'en_title'=>'required',
            'ru_title'=>'required',
            'az_description'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
        ]);


        $question->update( [

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

        if ($request->hasFile('sliders')) {
            foreach ($request->file('sliders') as $image) {
                $question->sliders()->create([
                    'image' => $this->imageUploadService->upload($image)
                ]);
            }
        }
        return redirect()->back()->with('message','Question updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {

        $question->delete();
        return redirect()->route('questions.index')->with('message', 'Question deleted successfully');

    }

    public function deleteImage($id)
    {

        DB::table('sliders')->where('id', '=', $id)->delete();
        return redirect()->back()->with('message','Şəkil silindi');

    }

}
