<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $r)
    {
        $q = Product::query();
        if ($search = $r->get('q')) {
            $q->where('name','like',"%$search%");
        }
        $products = $q->latest()->paginate(20);
        return view('customer.products', compact('products'));
    }

    public function adminIndex()
    {
        $products = Product::latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create() { return view('admin.products.create'); }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'=>'required',
            'description'=>'nullable',
            'price'=>'required|numeric|min:0',
            'category'=>'nullable',
            'stock'=>'required|integer|min:0',
            'image'=>'nullable|image'
        ]);
        if ($r->hasFile('image')) {
            $data['image'] = $r->file('image')->store('images','public');
        } else {
            $data['image'] = 'images/default-product.png';
        }
        Product::create($data);
        return redirect()->route('admin.products')->with('ok','Created.');
    }

    public function edit(Product $product) { return view('admin.products.edit', compact('product')); }

    public function update(Request $r, Product $product)
    {
        $data = $r->validate([
            'name'=>'required',
            'description'=>'nullable',
            'price'=>'required|numeric|min:0',
            'category'=>'nullable',
            'stock'=>'required|integer|min:0',
            'image'=>'nullable|image'
        ]);
        if ($r->hasFile('image')) {
            $data['image'] = $r->file('image')->store('images','public');
        }
        $product->update($data);
        return back()->with('ok','Updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('ok','Deleted.');
    }
}
