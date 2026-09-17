<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\LandingPageTemplate;
use App\Models\LandingPageVersion;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    protected array $reservedSlugs = [
        'admin', 'api', 'cart', 'checkout', 'product', 'products',
        'category', 'categories', 'login', 'logout', 'register',
        'track-order', 'order-success', 'storage', 'up',
    ];

    public function index(Request $request): View
    {
        $landingPages = LandingPage::with('product')
            ->latest()
            ->paginate(15);

        $products = Product::where('is_active', true)->get();
        $templates = LandingPageTemplate::where('is_active', true)->get();

        return view('admin.landing.index', compact('landingPages', 'products', 'templates'));
    }

    public function create(): View
    {
        $products = Product::where('is_active', true)->get();
        $templates = LandingPageTemplate::where('is_active', true)->get();

        return view('admin.landing.create', compact('products', 'templates'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'slug' => 'required|string|max:100|alpha_dash|unique:landing_pages,slug',
            'template_id' => 'nullable|exists:landing_page_templates,id',
            'status' => 'required|in:draft,published',
        ], [
            'name.required' => 'ল্যান্ডিং পেজের নাম আবশ্যক।',
            'product_id.required' => 'একটি প্রোডাক্ট নির্বাচন করুন।',
            'slug.required' => 'ইউআরএল স্ল্যাগ আবশ্যক।',
            'slug.unique' => 'এই স্ল্যাগটি ইতিমধ্যে ব্যবহৃত হয়েছে। অনুগ্রহ করে ভিন্ন একটি স্ল্যাগ দিন।',
        ]);

        if (in_array(strtolower($validated['slug']), $this->reservedSlugs, true)) {
            return back()->withErrors(['slug' => 'এই স্ল্যাগটি সিস্টেমের জন্য সংরক্ষিত। অনুগ্রহ করে ভিন্ন নাম দিন।'])->withInput();
        }

        $product = Product::findOrFail($validated['product_id']);

        // Default layout blocks if blank
        $initialContent = [
            [
                'id' => 'sec_hero',
                'type' => 'hero',
                'badge' => '🔥 বিশেষ অফার!',
                'title' => $product->name,
                'subtitle' => $product->short_description ?? 'প্রিমিয়াম কোয়ালিটি ও দ্রুত ডেলিভারির নিশ্চয়তা।',
                'cta_text' => 'এখনই অর্ডার করুন 🛒',
                'bg_color' => '#0f172a',
            ],
            [
                'id' => 'sec_urgency',
                'type' => 'urgency',
                'text' => '🔥 বিশেষ ছাড়ের অফার শেষ হতে বাকি:',
                'hours' => '05',
                'minutes' => '30',
                'seconds' => '00',
            ],
            [
                'id' => 'sec_features',
                'type' => 'features',
                'title' => 'কেন এই পণ্যটি কিনবেন?',
                'items' => ! empty($product->features) ? $product->features : [
                    '১০০% খাঁটি ও আসল মানের গ্যারান্টি',
                    'ক্যাশ অন ডেলিভারিতে চেক করে মূল্য পরিশোধ',
                    'সারাদেশে দ্রুততম হোম ডেলিভারি সুবিধা',
                ],
            ],
            [
                'id' => 'sec_order_form',
                'type' => 'order_form',
                'title' => 'অর্ডার কনফার্ম করতে নিচের তথ্য পূরণ করুন',
                'subtitle' => 'ডেলিভারি ম্যানের কাছে পণ্য পেয়ে মূল্য পরিশোধ করুন (ক্যাশ অন ডেলিভারি)',
            ],
        ];

        $customCss = '';

        if (! empty($validated['template_id'])) {
            $template = LandingPageTemplate::find($validated['template_id']);
            if ($template) {
                $customCss = $template->custom_css ?? '';
            }
        }

        $landingPage = LandingPage::create([
            'name' => $validated['name'],
            'product_id' => $validated['product_id'],
            'slug' => Str::slug($validated['slug']),
            'builder_type' => 'visual',
            'content' => json_encode($initialContent),
            'custom_css' => $customCss,
            'status' => $validated['status'],
            'seo_title' => $validated['name'].' - স্পেশাল অফার',
            'seo_description' => $product->short_description,
            'og_image' => $product->thumbnail,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.landing-pages.builder', $landingPage->id)
            ->with('success', 'ল্যান্ডিং পেজ তৈরি সম্পন্ন হয়েছে! এখন বিল্ডার দিয়ে ডিজাইন কাস্টমাইজ করুন।');
    }

    public function builder(LandingPage $landingPage): View
    {
        $landingPage->load('product.category');
        $product = $landingPage->product;
        $templates = LandingPageTemplate::where('is_active', true)->get();
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        $contentBlocks = [];
        if (! empty($landingPage->content)) {
            $decoded = json_decode($landingPage->content, true);
            $contentBlocks = is_array($decoded) ? $decoded : [];
        }

        return view('admin.landing.builder', compact(
            'landingPage',
            'product',
            'templates',
            'contentBlocks',
            'settings'
        ));
    }

    public function saveBuilder(Request $request, LandingPage $landingPage): JsonResponse
    {
        $validated = $request->validate([
            'content' => 'required',
            'custom_css' => 'nullable|string',
            'custom_js' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'fb_pixel_id' => 'nullable|string|max:100',
            'tiktok_pixel_id' => 'nullable|string|max:100',
            'gtm_id' => 'nullable|string|max:100',
        ]);

        $contentJson = is_array($request->content)
            ? json_encode($request->content)
            : (string) $request->content;

        // Save revision
        LandingPageVersion::create([
            'landing_page_id' => $landingPage->id,
            'content' => $landingPage->content,
            'custom_css' => $landingPage->custom_css,
            'version_number' => $landingPage->versions()->count() + 1,
            'created_by' => Auth::id(),
        ]);

        $landingPage->update([
            'content' => $contentJson,
            'custom_css' => $validated['custom_css'] ?? null,
            'custom_js' => $validated['custom_js'] ?? null,
            'seo_title' => $validated['seo_title'] ?? $landingPage->seo_title,
            'seo_description' => $validated['seo_description'] ?? $landingPage->seo_description,
            'fb_pixel_id' => $validated['fb_pixel_id'] ?? null,
            'tiktok_pixel_id' => $validated['tiktok_pixel_id'] ?? null,
            'gtm_id' => $validated['gtm_id'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ল্যান্ডিং পেজ সফলভাবে সেভ হয়েছে!',
        ]);
    }

    public function togglePublish(LandingPage $landingPage): RedirectResponse
    {
        $newStatus = $landingPage->status === 'published' ? 'draft' : 'published';
        $landingPage->update(['status' => $newStatus]);

        $msg = $newStatus === 'published'
            ? "ল্যান্ডিং পেজ সফলভাবে পাবলিশ করা হয়েছে! লাইভ ইউআরএল: /{$landingPage->slug}"
            : 'ল্যান্ডিং পেজ ড্রাফট করা হয়েছে।';

        return back()->with('success', $msg);
    }

    public function destroy(LandingPage $landingPage): RedirectResponse
    {
        $landingPage->delete();

        return redirect()->route('admin.landing-pages.index')
            ->with('success', 'ল্যান্ডিং পেজ সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
