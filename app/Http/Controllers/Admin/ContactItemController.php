<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-contact_lists|create-contact_lists|edit-contact_lists|delete-contact_lists', ['only' => ['index','show']]);
        $this->middleware('permission:create-contact_lists', ['only' => ['create','store']]);
        $this->middleware('permission:edit-contact_lists', ['only' => ['edit']]);
        $this->middleware('permission:delete-contact_lists', ['only' => ['destroy']]);
    }
    public function index()
    {

        $contact_items = ContactItem::paginate(10);
        return view('admin.contact_items.index', compact('contact_items'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.contact_items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'az_title'=>'nullable',
            'en_title'=>'nullable',
            'ru_title'=>'nullable',
            'az_value'=>'required',
            'en_value'=>'required',
            'ru_value'=>'required',
            'image'=>'required',
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }

        ContactItem::create([
            'image'=>  $filename,
            'az'=>[
                'title'=>$request->az_title,
                'value'=>$request->az_value,
            ],
            'en'=>[
                'title'=>$request->en_title,
                'value'=>$request->en_value,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'value'=>$request->ru_value,
            ]
        ]);

        return redirect()->route('contact_items.index')->with('message','ContactItem added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(ContactItem $contact_item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactItem $contact_item)
    {

        return view('admin.contact_items.edit', compact('contact_item'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, ContactItem $contact_item)
    {
        $request->validate([
            'az_title'=>'nullable',
            'en_title'=>'nullable',
            'ru_title'=>'nullable',
            'az_value'=>'required',
            'en_value'=>'required',
            'ru_value'=>'required',
        ]);

        if($request->hasFile('image')){

            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
            $contact_item->image = $filename;

        }

        $contact_item->update( [

            'is_active'=> $request->is_active,
            'az'=>[
                'title'=>$request->az_title,
                'value'=>$request->az_value,
            ],
            'en'=>[
                'title'=>$request->en_title,
                'value'=>$request->en_value,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
                'value'=>$request->ru_value,
            ]

        ]);

        return redirect()->back()->with('message','ContactItem updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactItem $contact_item)
    {

        $contact_item->delete();

        return redirect()->route('contact_items.index')->with('message', 'ContactItem deleted successfully');

    }
}
