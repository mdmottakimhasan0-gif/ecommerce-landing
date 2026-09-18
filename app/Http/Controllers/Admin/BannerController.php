<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends Controller
{
    /**
     * Get default homepage banner settings.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function getDefaultBanners(): array
    {
        return [
            'banner1' => [
                'badge' => '🌿 প্রিমিয়াম অর্গানিক ও লাইফস্টাইল কালেকশন',
                'title' => 'প্রকৃতির খাঁটি স্বাদ ও আধুনিক গ্যাজেটের সেরা সমাহার!',
                'subtitle' => 'সুন্দরবনের প্রাকৃতিক চাকের মধু, কাঠের ঘানি ভাঙা খাঁটি সরিষার তেল, স্মার্ট কিচেন চপার এবং ট্রেন্ডিং ইলেকট্রনিক্স গ্যাজেটস।',
                'btn1_text' => 'সব পণ্য দেখুন 🛒',
                'btn1_link' => '/products',
                'btn2_text' => 'খাঁটি অর্গানিক ফুড →',
                'btn2_link' => '/products?category=organic-products',
                'image' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=800&auto=format&fit=crop&q=80',
                'bg_gradient' => 'from-emerald-900 via-teal-900 to-slate-900',
                'is_active' => true,
                'show_text' => false,
            ],
            'banner2' => [
                'badge' => 'স্মার্ট হোম ও কিচেন',
                'title' => 'মাল্টিফাংশন ভেজিটেবল চপার ও কাটার',
                'subtitle' => 'রান্নার সময় বাঁচান নিমেষেই! মাত্র ৳ ৭৯০',
                'link_text' => 'অর্ডার করুন এখনই →',
                'link_url' => '/products?category=home-kitchen',
                'image' => '',
                'bg_gradient' => 'from-amber-700 to-orange-900',
                'is_active' => true,
                'show_text' => false,
            ],
            'banner3' => [
                'badge' => 'মেগা টেক ডিসকাউন্ট',
                'title' => 'T9 ভিন্টেজ হেয়ার ট্রিমার ও স্মার্ট ওয়াচ',
                'subtitle' => '১ বছরের রিপ্লেসমেন্ট গ্যারান্টি সহ!',
                'link_text' => 'অফার দেখুন →',
                'link_url' => '/products?category=electronics-gadgets',
                'image' => '',
                'bg_gradient' => 'from-blue-900 to-indigo-950',
                'is_active' => true,
                'show_text' => false,
            ],
        ];
    }

    /**
     * Show the homepage banners management page.
     */
    public function index(): View
    {
        $defaults = self::getDefaultBanners();
        $storedRaw = Setting::get('home_banners');

        $banners = $defaults;
        if (! empty($storedRaw)) {
            $decoded = json_decode($storedRaw, true);
            if (is_array($decoded)) {
                $banners['banner1'] = array_merge($defaults['banner1'], $decoded['banner1'] ?? []);
                $banners['banner2'] = array_merge($defaults['banner2'], $decoded['banner2'] ?? []);
                $banners['banner3'] = array_merge($defaults['banner3'], $decoded['banner3'] ?? []);
            }
        }

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Update homepage banners and upload images.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'banner1_file' => 'nullable|file|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
            'banner2_file' => 'nullable|file|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
            'banner3_file' => 'nullable|file|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
            'banner1_title' => 'nullable|string|max:255',
            'banner2_title' => 'nullable|string|max:255',
            'banner3_title' => 'nullable|string|max:255',
        ]);

        $defaults = self::getDefaultBanners();
        $storedRaw = Setting::get('home_banners');
        $existing = $defaults;
        if (! empty($storedRaw)) {
            $decoded = json_decode($storedRaw, true);
            if (is_array($decoded)) {
                $existing['banner1'] = array_merge($defaults['banner1'], $decoded['banner1'] ?? []);
                $existing['banner2'] = array_merge($defaults['banner2'], $decoded['banner2'] ?? []);
                $existing['banner3'] = array_merge($defaults['banner3'], $decoded['banner3'] ?? []);
            }
        }

        // 1. Process Banner 1
        $banner1Image = $existing['banner1']['image'] ?? '';
        if ($request->hasFile('banner1_file')) {
            $path = $request->file('banner1_file')->store('banners', 'public');
            $banner1Image = asset('storage/'.$path);
        } elseif ($request->filled('banner1_image_url')) {
            $banner1Image = $request->input('banner1_image_url');
        }

        $banner1 = [
            'badge' => $request->input('banner1_badge', $existing['banner1']['badge']),
            'title' => $request->input('banner1_title', $existing['banner1']['title']),
            'subtitle' => $request->input('banner1_subtitle', $existing['banner1']['subtitle']),
            'btn1_text' => $request->input('banner1_btn1_text', $existing['banner1']['btn1_text']),
            'btn1_link' => $request->input('banner1_btn1_link', $existing['banner1']['btn1_link']),
            'btn2_text' => $request->input('banner1_btn2_text', $existing['banner1']['btn2_text']),
            'btn2_link' => $request->input('banner1_btn2_link', $existing['banner1']['btn2_link']),
            'image' => $banner1Image,
            'bg_gradient' => $request->input('banner1_bg_gradient', $existing['banner1']['bg_gradient']),
            'is_active' => $request->boolean('banner1_is_active', true),
            'show_text' => $request->boolean('banner1_show_text', false),
        ];

        // 2. Process Banner 2
        $banner2Image = $existing['banner2']['image'] ?? '';
        if ($request->hasFile('banner2_file')) {
            $path = $request->file('banner2_file')->store('banners', 'public');
            $banner2Image = asset('storage/'.$path);
        } elseif ($request->filled('banner2_image_url')) {
            $banner2Image = $request->input('banner2_image_url');
        }

        $banner2 = [
            'badge' => $request->input('banner2_badge', $existing['banner2']['badge']),
            'title' => $request->input('banner2_title', $existing['banner2']['title']),
            'subtitle' => $request->input('banner2_subtitle', $existing['banner2']['subtitle']),
            'link_text' => $request->input('banner2_link_text', $existing['banner2']['link_text']),
            'link_url' => $request->input('banner2_link_url', $existing['banner2']['link_url']),
            'image' => $banner2Image,
            'bg_gradient' => $request->input('banner2_bg_gradient', $existing['banner2']['bg_gradient']),
            'is_active' => $request->boolean('banner2_is_active', true),
            'show_text' => $request->boolean('banner2_show_text', false),
        ];

        // 3. Process Banner 3
        $banner3Image = $existing['banner3']['image'] ?? '';
        if ($request->hasFile('banner3_file')) {
            $path = $request->file('banner3_file')->store('banners', 'public');
            $banner3Image = asset('storage/'.$path);
        } elseif ($request->filled('banner3_image_url')) {
            $banner3Image = $request->input('banner3_image_url');
        }

        $banner3 = [
            'badge' => $request->input('banner3_badge', $existing['banner3']['badge']),
            'title' => $request->input('banner3_title', $existing['banner3']['title']),
            'subtitle' => $request->input('banner3_subtitle', $existing['banner3']['subtitle']),
            'link_text' => $request->input('banner3_link_text', $existing['banner3']['link_text']),
            'link_url' => $request->input('banner3_link_url', $existing['banner3']['link_url']),
            'image' => $banner3Image,
            'bg_gradient' => $request->input('banner3_bg_gradient', $existing['banner3']['bg_gradient']),
            'is_active' => $request->boolean('banner3_is_active', true),
            'show_text' => $request->boolean('banner3_show_text', false),
        ];

        $payload = [
            'banner1' => $banner1,
            'banner2' => $banner2,
            'banner3' => $banner3,
        ];

        Setting::set('home_banners', json_encode($payload), 'homepage');

        return redirect()->route('admin.banners.index')
            ->with('success', 'হোমপেজের ৩টি ব্যানার ও টেক্সট সফলভাবে আপডেট করা হয়েছে!');
    }
}
