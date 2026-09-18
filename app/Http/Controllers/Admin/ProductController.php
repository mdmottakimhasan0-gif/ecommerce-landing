<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with(['category', 'landingPages'])
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'sku' => 'nullable|string|max:100',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'thumbnail' => $request->hasFile('thumbnail')
                ? 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120'
                : 'required',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'features_input' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_flash_deal' => 'boolean',
        ]);

        $slug = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']).'-'.rand(100, 999);

        // Upload main thumbnail file or fallback to string
        $thumbnailUrl = '';
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('products', 'public');
            $thumbnailUrl = Storage::url($path);
        } elseif (is_string($request->thumbnail)) {
            $thumbnailUrl = $request->thumbnail;
        }

        // Upload gallery image files
        $gallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $imageFile) {
                if ($imageFile && $imageFile->isValid()) {
                    $path = $imageFile->store('products/gallery', 'public');
                    $gallery[] = Storage::url($path);
                }
            }
        } elseif (! empty($request->gallery_input)) {
            $gallery = array_filter(array_map('trim', explode("\n", $request->gallery_input)));
        }

        // Parse features (one per line)
        $features = [];
        if (! empty($request->features_input)) {
            $features = array_filter(array_map('trim', explode("\n", $request->features_input)));
        }

        Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'sku' => $validated['sku'] ?? 'SKU-'.rand(1000, 9999),
            'regular_price' => $validated['regular_price'],
            'sale_price' => $validated['sale_price'],
            'stock' => $validated['stock'],
            'thumbnail' => $thumbnailUrl,
            'gallery' => $gallery,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'features' => $features,
            'is_active' => $request->boolean('is_active', true),
            'is_featured' => $request->boolean('is_featured'),
            'is_flash_deal' => $request->boolean('is_flash_deal'),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'প্রোডাক্ট সফলভাবে তৈরি করা হয়েছে।');
    }

    public function edit(Product $product): View
    {
        $categories = Category::where('is_active', true)->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,'.$product->id,
            'sku' => 'nullable|string|max:100',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'existing_gallery' => 'nullable|array',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'features_input' => 'nullable|string',
        ]);

        $thumbnailUrl = $product->thumbnail;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('products', 'public');
            $thumbnailUrl = Storage::url($path);
        } elseif ($request->boolean('remove_thumbnail')) {
            $thumbnailUrl = null;
        } elseif (is_string($request->thumbnail) && ! empty($request->thumbnail)) {
            $thumbnailUrl = $request->thumbnail;
        }

        // Merge retained existing gallery + newly uploaded gallery images
        $gallery = $request->input('existing_gallery', []);
        if (! is_array($gallery)) {
            $gallery = [];
        }
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $imageFile) {
                if ($imageFile && $imageFile->isValid()) {
                    $path = $imageFile->store('products/gallery', 'public');
                    $gallery[] = Storage::url($path);
                }
            }
        } elseif (! empty($request->gallery_input)) {
            $gallery = array_filter(array_map('trim', explode("\n", $request->gallery_input)));
        }

        $features = [];
        if (! empty($request->features_input)) {
            $features = array_filter(array_map('trim', explode("\n", $request->features_input)));
        }

        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => ! empty($validated['slug']) ? Str::slug($validated['slug']) : $product->slug,
            'sku' => $validated['sku'] ?? $product->sku,
            'regular_price' => $validated['regular_price'],
            'sale_price' => $validated['sale_price'],
            'stock' => $validated['stock'],
            'thumbnail' => $thumbnailUrl,
            'gallery' => $gallery,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'features' => $features,
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
            'is_flash_deal' => $request->boolean('is_flash_deal'),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'প্রোডাক্ট সফলভাবে আপডেট করা হয়েছে। সব সংযুক্ত ল্যান্ডিং পেজেও নতুন তথ্য স্বয়ংক্রিয়ভাবে কার্যকর হয়েছে!');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'প্রোডাক্ট মুছে ফেলা হয়েছে।');
    }
}
