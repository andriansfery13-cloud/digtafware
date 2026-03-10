<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'features' => 'nullable|string',
            'requirements' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'is_enterprise' => 'boolean',
            'demo_url' => 'nullable|url',
            'demo_video_url' => 'nullable|url',
            'version' => 'nullable|string|max:50',
            'file' => 'required_unless:is_enterprise,1|file|mimes:zip,rar,pdf|max:102400', // 100MB max
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_enterprise'] = $request->has('is_enterprise');

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('products/files', 'local');
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('products/thumbnails', 'public');
        }

        $product = Product::create($validated);

        if ($request->hasFile('screenshots')) {
            foreach ($request->file('screenshots') as $index => $screenshot) {
                $path = $screenshot->store('products/screenshots', 'public');
                $product->screenshots()->create([
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'features' => 'nullable|string',
            'requirements' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'is_enterprise' => 'boolean',
            'demo_url' => 'nullable|url',
            'demo_video_url' => 'nullable|url',
            'version' => 'nullable|string|max:50',
            'file' => 'nullable|file|mimes:zip,rar,pdf|max:102400',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_enterprise'] = $request->has('is_enterprise');

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('products/files', 'local');
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('products/thumbnails', 'public');
        }

        $product->update($validated);

        if ($request->hasFile('screenshots')) {
            foreach ($request->file('screenshots') as $index => $screenshot) {
                $path = $screenshot->store('products/screenshots', 'public');
                $product->screenshots()->create([
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Keep files for historical orders, or delete them if strict DB cleanup is preferred.
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
