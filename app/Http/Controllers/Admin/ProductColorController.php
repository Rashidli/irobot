<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductColorController extends Controller
{

    public function index(Product $product)
    {

        $product_colors = $product->product_colors()->paginate(10);
        return view('admin.product_colors.index', compact('product', 'product_colors'));

    }

    public function create(Product $product)
    {

        return view('admin.product_colors.create', compact('product'));

    }

    public function store(Request $request, Product $product)
    {

        $request->validate([
            'az_title' => 'required',
            'en_title' => 'required',
            'ru_title' => 'required',
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = Str::uuid() . "." . $file->extension();
            $file->storeAs('public/',$filename);
        }

        $product->product_colors()->create([
            'image' =>$filename,
            'is_default' =>isset($request->is_default),
            'az' => [
                'title' => $request->az_title,
            ],
            'en' => [
                'title' => $request->en_title,
            ],
            'ru' => [
                'title' => $request->ru_title,
            ],
        ]);

        return redirect()->route('products.product_colors.index', $product)->with('message', 'Product Color added successfully');

    }

    public function edit(Product $product, ProductColor $product_color)
    {

        return view('admin.product_colors.edit', compact('product', 'product_color'));

    }

    public function update(Request $request, Product $product, ProductColor $product_color)
    {

        try {
            $request->validate([
                'az_title' => 'required',
                'en_title' => 'required',
                'ru_title' => 'required',
            ]);

            $product_color->update([
                'is_active' => $request->is_active,
                'is_default' => isset($request->is_default),
                'az' => [
                    'title' => $request->az_title,
                ],
                'en' => [
                    'title' => $request->en_title,
                ],
                'ru' => [
                    'title' => $request->ru_title,
                ],
            ]);

            if($request->hasFile('image')){

                $file = $request->file('image');
                $filename = Str::uuid() . "." . $file->extension();
                $file->storeAs('public/',$filename);
                $product_color->image = $filename;

            }

        }catch (\Exception $exception){

            return $exception->getMessage();

        }

        return redirect()->route('products.product_colors.index', $product)->with('message', 'Product Color updated successfully');

    }

    public function destroy(Product $product, ProductColor $product_color)
    {

        $product_color->delete();
        return redirect()->route('products.product_colors.index', $product)->with('message', 'Product Color deleted successfully');

    }

}
