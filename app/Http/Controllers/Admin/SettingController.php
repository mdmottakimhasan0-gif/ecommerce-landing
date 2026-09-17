<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $fields = [
            'store_name', 'store_tagline', 'store_phone', 'store_whatsapp',
            'store_email', 'store_address', 'delivery_inside_dhaka',
            'delivery_outside_dhaka', 'fb_pixel_id', 'tiktok_pixel_id',
            'gtm_id', 'custom_head_scripts', 'announcement_text',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::set($field, $request->input($field));
            }
        }

        return back()->with('success', 'পিক্সেল এবং স্টোর সেটিংস সফলভাবে আপডেট করা হয়েছে!');
    }
}
