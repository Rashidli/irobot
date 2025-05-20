<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use App\Models\AccessoryCategory;
use App\Models\AccessorySerie;
use App\Models\AccessoryType;
use App\Models\Category;
use App\Models\Type;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccessoryController extends Controller
{

    public function __construct(protected ImageUploadService $imageUploadService)
    {
//        $this->middleware('permission:list-accessories|create-accessories|edit-accessories|delete-accessories', ['only' => ['index','show']]);
//        $this->middleware('permission:create-accessories', ['only' => ['create','store']]);
//        $this->middleware('permission:edit-accessories', ['only' => ['edit']]);
//        $this->middleware('permission:delete-accessories', ['only' => ['destroy']]);
    }

    function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = Accessory::whereTranslation('title', $title)->count();

        if ($count > 0) {
            $slug .= '-' . $count;
        }

        return $slug;
    }

    public function index()
    {

        $accessories = Accessory::query()->orderByDesc('id')->paginate(10);
        return view('admin.accessories.index', compact('accessories'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $categories = AccessoryCategory::all();
        $types = AccessoryType::query()->active()->get();
        $series = AccessorySerie::all();
        return view('admin.accessories.create', compact('categories','types','series'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'az_title'=>'required',
            'en_title'=>'required',
            'ru_title'=>'required',
            'az_img_alt'=>'nullable',
            'en_img_alt'=>'nullable',
            'ru_img_alt'=>'nullable',
            'az_img_title'=>'nullable',
            'en_img_title'=>'nullable',
            'ru_img_title'=>'nullable',
            'az_description'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
            'image'=>'required',
            'accessory_category_id'=>'required',
            'accessory_type_id'=>'required',
            'accessory_serie_id'=>'required',
        ]);

        DB::beginTransaction();

        try {
            if($request->hasFile('image')){
                $filename = $this->imageUploadService->upload($request->file('image'));
            }

            $accessory = Accessory::create([
                'image'=>  $filename,
                'accessory_category_id'=> $request->accessory_category_id,
                'accessory_type_id'=> $request->accessory_type_id,
                'accessory_serie_id'=> $request->accessory_serie_id,
                'is_stock'=> isset($request->is_stock),
                'is_bestseller'=> isset($request->is_bestseller),
                'price' =>$request->price,
                'code' =>$request->code,
                'room_area' =>$request->room_area,
                'discounted_price' =>$request->discounted_price,
                'az'=>[
                    'title'=>$request->az_title,
                    'description'=>$request->az_description,
                    'img_alt'=>$request->az_img_alt,
                    'img_title'=>$request->az_img_title,
                    'slug'=>$this->generateUniqueSlug($request->az_title),
                    'meta_title'=>$request->az_meta_title,
                    'meta_description'=>$request->az_meta_description,
                    'meta_keywords'=>$request->az_meta_keywords,
                ],
                'en'=>[
                    'title'=>$request->en_title,
                    'description'=>$request->en_description,
                    'img_alt'=>$request->en_img_alt,
                    'img_title'=>$request->en_img_title,
                    'slug'=>$this->generateUniqueSlug($request->en_title),
                    'meta_title'=>$request->en_meta_title,
                    'meta_description'=>$request->en_meta_description,
                    'meta_keywords'=>$request->en_meta_keywords,
                ],
                'ru'=>[
                    'title'=>$request->ru_title,
                    'description'=>$request->ru_description,
                    'img_alt'=>$request->ru_img_alt,
                    'img_title'=>$request->ru_img_title,
                    'slug'=>$this->generateUniqueSlug($request->ru_title),
                    'meta_title'=>$request->ru_meta_title,
                    'meta_description'=>$request->ru_meta_description,
                    'meta_keywords'=>$request->ru_meta_keywords,
                ]
            ]);

            if ($request->hasFile('slider_images')) {
                foreach ($request->file('slider_images') as $file) {
                    $filename = $this->imageUploadService->upload($file);
                    $accessory->sliders()->create([
                        'image' => $filename,
                    ]);
                }
            }

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }

        return redirect()->route('accessories.index')->with('message','Accessory added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Accessory $accessory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Accessory $accessory)
    {
        $categories = AccessoryCategory::all();
        $types = AccessoryType::query()->active()->get();
        $series = AccessorySerie::all();
        return view('admin.accessories.edit', compact('accessory','categories','types','series'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Accessory $accessory)
    {
        $request->validate([
            'az_title'=>'required',
            'en_title'=>'required',
            'ru_title'=>'required',
            'az_img_alt'=>'nullable',
            'en_img_alt'=>'nullable',
            'ru_img_alt'=>'nullable',
            'az_img_title'=>'nullable',
            'en_img_title'=>'nullable',
            'ru_img_title'=>'nullable',
            'az_description'=>'required',
            'en_description'=>'required',
            'ru_description'=>'required',
            'accessory_category_id'=>'required',
            'accessory_type_id'=>'required',
            'accessory_serie_id'=>'required',
        ]);

        DB::beginTransaction();
        try {

            if($request->hasFile('image')){
                $accessory->image = $this->imageUploadService->upload($request->file('image'));
            }

            $accessory->update( [
                'is_active'=> $request->is_active,
                'accessory_category_id'=> $request->accessory_category_id,
                'accessory_type_id'=> $request->accessory_type_id,
                'accessory_serie_id'=> $request->accessory_serie_id,
                'is_stock'=> isset($request->is_stock),
                'is_bestseller'=> isset($request->is_bestseller),
                'price' =>$request->price,
                'discounted_price' =>$request->discounted_price,
                'code' =>$request->code,
                'room_area' =>$request->room_area,
                'az'=>[
                    'title'=>$request->az_title,
                    'img_alt'=>$request->az_img_alt,
                    'img_title'=>$request->az_img_title,
                    'description'=>$request->az_description,
                    'meta_title'=>$request->az_meta_title,
                    'meta_description'=>$request->az_meta_description,
                    'meta_keywords'=>$request->az_meta_keywords,
                ],
                'en'=>[
                    'title'=>$request->en_title,
                    'img_alt'=>$request->en_img_alt,
                    'img_title'=>$request->en_img_title,
                    'description'=>$request->en_description,
                    'meta_title'=>$request->en_meta_title,
                    'meta_description'=>$request->en_meta_description,
                    'meta_keywords'=>$request->en_meta_keywords,
                ],
                'ru'=>[
                    'title'=>$request->ru_title,
                    'img_alt'=>$request->ru_img_alt,
                    'img_title'=>$request->ru_img_title,
                    'description'=>$request->ru_description,
                    'meta_title'=>$request->ru_meta_title,
                    'meta_description'=>$request->ru_meta_description,
                    'meta_keywords'=>$request->ru_meta_keywords,
                ]

            ]);

            if ($request->hasFile('sliders')) {
                foreach ($request->file('sliders') as $image) {
                    $accessory->sliders()->create([
                        'image' => $this->imageUploadService->upload($image)
                    ]);
                }
            }

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }
        return redirect()->back()->with('message','Accessory updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accessory $accessory)
    {

        $accessory->delete();
        return redirect()->route('accessories.index')->with('message', 'Accessory deleted successfully');

    }
}
