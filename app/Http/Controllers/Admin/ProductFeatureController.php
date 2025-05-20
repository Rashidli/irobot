<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductFeatureController extends Controller
{
    public function index(Product $product)
    {
        $product_features = $product->product_features()->paginate(10);
        return view('admin.product_features.index', compact('product', 'product_features'));
    }

    public function create(Product $product)
    {
        return view('admin.product_features.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'az_title' => 'required',
            'en_title' => 'required',
            'ru_title' => 'required',
            'az_description' => 'nullable',
            'en_description' => 'nullable',
            'ru_description' => 'nullable',
        ]);
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }
        $product->product_features()->create([ // Using the relationship to associate Detail with the product
            'image' =>$filename,
            'az' => [
                'title' => $request->az_title,
                'description' => $request->az_description,
            ],
            'en' => [
                'title' => $request->en_title,
                'description' => $request->en_description,
            ],
            'ru' => [
                'title' => $request->ru_title,
                'description' => $request->ru_description,
            ],
        ]);

        return redirect()->route('products.product_features.index', $product)->with('message', 'Product Detail added successfully');
    }

    public function edit(Product $product, ProductFeature $product_feature)
    {
        return view('admin.product_features.edit', compact('product', 'product_feature'));
    }

    public function update(Request $request, Product $product, ProductFeature $product_feature)
    {

        try {
            $request->validate([
                'az_title' => 'required',
                'en_title' => 'required',
                'ru_title' => 'required',
                'az_description' => 'nullable',
                'en_description' => 'nullable',
                'ru_description' => 'nullable',
            ]);

            $product_feature->update([
                'is_active' => $request->is_active,
                'az' => [
                    'title' => $request->az_title,
                    'description' => $request->az_description,
                ],
                'en' => [
                    'title' => $request->en_title,
                    'description' => $request->en_description,
                ],
                'ru' => [
                    'title' => $request->ru_title,
                    'description' => $request->ru_description,
                ],
            ]);

            if($request->hasFile('image')){

                $file = $request->file('image');
                $filename = Str::uuid() . "." . $file->extension();
                $file->storeAs('public/',$filename);
                $product_feature->image = $filename;

            }

        }catch (\Exception $exception){
            return $exception->getMessage();
        }

        return redirect()->route('products.product_features.index', $product)->with('message', 'Product Detail updated successfully');
    }

    public function destroy(Product $product, ProductFeature $product_feature)
    {
        $product_feature->delete();
        return redirect()->route('products.product_features.index', $product)->with('message', 'Product Detail deleted successfully');
    }
}
