<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccessoryResource;
use App\Models\Accessory;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSerie;
use App\Models\Type;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {
//        $this->middleware('permission:list-products|create-products|edit-products|delete-products', ['only' => ['index','show']]);
//        $this->middleware('permission:create-products', ['only' => ['create','store']]);
//        $this->middleware('permission:edit-products', ['only' => ['edit']]);
//        $this->middleware('permission:delete-products', ['only' => ['destroy']]);
    }

    function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = Product::whereTranslation('title', $title)->count();

        if ($count > 0) {
            $slug .= '-' . $count;
        }

        return $slug;
    }

    public function index()
    {

        $products = Product::query()->orderByDesc('id')->paginate(10);
        return view('admin.products.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $categories = Category::all();
        $types = Type::query()->active()->get();
        $product_series = ProductSerie::all();
        $accessories = Accessory::query()->active()->get();
        return view('admin.products.create', compact(
            'categories','types','product_series','accessories'));
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
            'category_id'=>'required',
            'type_id'=>'required',
            'product_serie_id'=>'required',
        ]);

        DB::beginTransaction();

        try {
            if($request->hasFile('image')){
                $filename = $this->imageUploadService->upload($request->file('image'));
            }

            $product = Product::create([
                'image'=>  $filename,
                'category_id'=> $request->category_id,
                'type_id'=> $request->type_id,
                'is_stock'=> isset($request->is_stock),
                'is_new'=> isset($request->is_new),
                'is_bestseller'=> isset($request->is_bestseller),
                'is_paket'=> isset($request->is_paket),
                'price' =>$request->price,
                'product_serie_id' =>$request->product_serie_id,
                'code' =>$request->code,
                'room_area' =>$request->room_area,
                'discounted_price' =>$request->discounted_price,
                'mess_coming' =>$request->mess_coming,
                'floor_home' =>$request->floor_home,
                'level_clutter' =>$request->level_clutter,
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
                    $product->sliders()->create([
                        'image' => $filename,
                    ]);
                }
            }

            if ($request->accessories){
                $product->accessories()->attach($request->accessories);
            }

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }

        return redirect()->route('products.index')->with('message','Product added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $types = Type::query()->active()->get();
        $product_series = ProductSerie::all();
        $accessories = Accessory::query()->active()->get();
        return view('admin.products.edit', compact(
            'product','categories','types','product_series','accessories'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Product $product)
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
            'category_id'=>'required',
            'type_id'=>'required',
            'product_serie_id'=>'required',
        ]);

        DB::beginTransaction();

        try {

            if($request->hasFile('image')){
                $product->image = $this->imageUploadService->upload($request->file('image'));
            }

            $product->update( [
                'is_active'=> $request->is_active,
                'category_id'=> $request->category_id,
                'type_id'=> $request->type_id,
                'product_serie_id'=> $request->product_serie_id,
                'is_stock'=> isset($request->is_stock),
                'is_new'=> isset($request->is_new),
                'is_bestseller'=> isset($request->is_bestseller),
                'is_paket'=> isset($request->is_paket),
                'price' => $request->price,
                'discounted_price' => $request->discounted_price,
                'code' => $request->code,
                'room_area' => $request->room_area,
                'mess_coming' => $request->mess_coming,
                'floor_home' => $request->floor_home,
                'level_clutter' => $request->level_clutter,
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
                    $product->sliders()->create([
                        'image' => $this->imageUploadService->upload($image)
                    ]);
                }
            }

            if ($request->accessories){
                $product->accessories()->sync($request->accessories);
            }

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }
        return redirect()->back()->with('message','Product updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        $product->delete();
        return redirect()->route('products.index')->with('message', 'Product deleted successfully');

    }
}
