<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductDetailController extends Controller
{
    public function index(Product $product)
    {
        $product_details = $product->product_details()->paginate(10);
        return view('admin.product_details.index', compact('product', 'product_details'));
    }

    public function create(Product $product)
    {
        return view('admin.product_details.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'az_title' => 'required',
            'en_title' => 'required',
            'ru_title' => 'required',
            'az_description' => 'required',
            'en_description' => 'required',
            'ru_description' => 'required',
        ]);
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }
        $product->product_details()->create([ // Using the relationship to associate Detail with the product
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

        return redirect()->route('products.product_details.index', $product)->with('message', 'Product Detail added successfully');
    }

    public function edit(Product $product, ProductDetail $product_detail)
    {
        return view('admin.product_details.edit', compact('product', 'product_detail'));
    }

    public function update(Request $request, Product $product, ProductDetail $product_detail)
    {

        try {
            $request->validate([
                'az_title' => 'required',
                'en_title' => 'required',
                'ru_title' => 'required',
                'az_description' => 'required',
                'en_description' => 'required',
                'ru_description' => 'required',
            ]);

            $product_detail->update([
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
                $product_detail->image = $filename;

            }

        }catch (\Exception $exception){
            return $exception->getMessage();
        }

        return redirect()->route('products.product_details.index', $product)->with('message', 'Product Detail updated successfully');
    }

    public function destroy(Product $product, ProductDetail $product_detail)
    {
        $product_detail->delete();
        return redirect()->route('products.product_details.index', $product)->with('message', 'Product Detail deleted successfully');
    }
}
