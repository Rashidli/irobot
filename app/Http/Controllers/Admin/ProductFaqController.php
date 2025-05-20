<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductFaq;
use Illuminate\Http\Request;

class ProductFaqController extends Controller
{
    public function index(Product $product)
    {
        $product_faqs = $product->product_faqs()->paginate(10);
        return view('admin.product_faqs.index', compact('product', 'product_faqs'));
    }

    public function create(Product $product)
    {
        return view('admin.product_faqs.create', compact('product'));
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

        $product->product_faqs()->create([ // Using the relationship to associate FAQ with the product
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

        return redirect()->route('products.product_faqs.index', $product)->with('message', 'Product FAQ added successfully');
    }

    public function edit(Product $product, ProductFaq $product_faq)
    {
        return view('admin.product_faqs.edit', compact('product', 'product_faq'));
    }

    public function update(Request $request, Product $product, ProductFaq $product_faq)
    {
        $request->validate([
            'az_title' => 'required',
            'en_title' => 'required',
            'ru_title' => 'required',
            'az_description' => 'required',
            'en_description' => 'required',
            'ru_description' => 'required',
        ]);

        $product_faq->update([
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

        return redirect()->route('products.product_faqs.index', $product)->with('message', 'Product FAQ updated successfully');
    }

    public function destroy(Product $product, ProductFaq $product_faq)
    {
        $product_faq->delete();
        return redirect()->route('products.product_faqs.index', $product)->with('message', 'Product FAQ deleted successfully');
    }
}
