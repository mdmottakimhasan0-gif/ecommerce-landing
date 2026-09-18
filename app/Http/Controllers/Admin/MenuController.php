<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    /**
     * Get the default navigation menu items.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getDefaultMenuItems(): array
    {
        return [
            [
                'id' => 'm_home',
                'icon' => '',
                'title' => 'হোমপেজ',
                'url' => '/',
                'is_active' => true,
            ],
            [
                'id' => 'm_products',
                'icon' => '',
                'title' => 'সব প্রোডাক্ট',
                'url' => '/products',
                'is_active' => true,
            ],
            [
                'id' => 'm_organic',
                'icon' => '🌿',
                'title' => 'অর্গানিক ফুড',
                'url' => '/products?category=organic-products',
                'is_active' => true,
            ],
            [
                'id' => 'm_kitchen',
                'icon' => '🍳',
                'title' => 'হোম ও কিচেন',
                'url' => '/products?category=home-kitchen',
                'is_active' => true,
            ],
            [
                'id' => 'm_electronics',
                'icon' => '⚡',
                'title' => 'ইলেকট্রনিক্স ও গ্যাজেট',
                'url' => '/products?category=electronics-gadgets',
                'is_active' => true,
            ],
        ];
    }

    /**
     * Display the header menu and top announcement settings page.
     */
    public function index(): View
    {
        $defaultMenu = self::getDefaultMenuItems();
        $storedMenuRaw = Setting::get('header_nav_menu');

        $menuItems = $defaultMenu;
        if (! empty($storedMenuRaw)) {
            $decoded = json_decode($storedMenuRaw, true);
            if (is_array($decoded)) {
                $menuItems = $decoded;
            }
        }

        $alignment = Setting::get('header_nav_alignment', 'center');
        $announcementActive = Setting::get('announcement_active', '1') === '1';
        $announcementText = Setting::get('announcement_text', '🔥 সারাদেশে ক্যাশ অন ডেলিভারি | ৪৮ ঘণ্টার মধ্যে নিশ্চিত হোম ডেলিভারি!');

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.menus.index', compact(
            'menuItems',
            'alignment',
            'announcementActive',
            'announcementText',
            'categories'
        ));
    }

    /**
     * Save header navigation menu items and top announcement bar settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'header_nav_alignment' => 'required|in:left,center,right',
            'announcement_text' => 'nullable|string|max:500',
            'menu_items' => 'nullable|array',
            'menu_items.*.title' => 'required|string|max:100',
            'menu_items.*.url' => 'required|string|max:255',
            'menu_items.*.icon' => 'nullable|string|max:50',
        ]);

        $rawItems = $request->input('menu_items', []);
        $sanitizedItems = [];

        if ($request->boolean('restore_defaults')) {
            $sanitizedItems = self::getDefaultMenuItems();
        } else {
            foreach ($rawItems as $idx => $item) {
                if (! empty($item['title']) && ! empty($item['url'])) {
                    $sanitizedItems[] = [
                        'id' => $item['id'] ?? ('m_'.time().'_'.$idx),
                        'icon' => trim($item['icon'] ?? ''),
                        'title' => trim($item['title']),
                        'url' => trim($item['url']),
                        'is_active' => ! empty($item['is_active']),
                    ];
                }
            }
        }

        // If user deleted all, default back or keep empty as requested
        Setting::set('header_nav_menu', json_encode($sanitizedItems), 'header');
        Setting::set('header_nav_alignment', $request->input('header_nav_alignment', 'center'), 'header');
        Setting::set('announcement_active', $request->boolean('announcement_active') ? '1' : '0', 'header');
        Setting::set('announcement_text', $request->input('announcement_text', '🔥 সারাদেশে ক্যাশ অন ডেলিভারি | ৪৮ ঘণ্টার মধ্যে নিশ্চিত হোম ডেলিভারি!'), 'header');

        return redirect()->route('admin.menus.index')
            ->with('success', 'হেডার নেভিগেশন মেনু ও টপ অ্যানাউন্সমেন্ট বার সফলভাবে আপডেট করা হয়েছে!');
    }
}
