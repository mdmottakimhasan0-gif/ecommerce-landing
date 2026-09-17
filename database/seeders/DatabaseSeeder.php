<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\LandingPage;
use App\Models\LandingPageTemplate;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@demandhat.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_admin' => true,
            ]
        );

        // 2. Settings (Store config & Multi-pixel tracking)
        $settings = [
            'store_name' => 'DemandHat BD',
            'store_tagline' => 'সেরা মূল্যে ১০০% জেনুইন ও প্রিমিয়াম কোয়ালিটি পণ্য',
            'store_phone' => '01712-345678',
            'store_whatsapp' => '01712-345678',
            'store_email' => 'support@demandhatbd.com',
            'store_address' => 'Mirpur-10, Dhaka-1216, Bangladesh',
            'delivery_inside_dhaka' => '70',
            'delivery_outside_dhaka' => '130',
            'fb_pixel_id' => '123456789012345',
            'tiktok_pixel_id' => 'TT-DEMO-998877',
            'gtm_id' => 'GTM-DEMAND01',
            'custom_head_scripts' => '<!-- DemandHat Tracking Scripts Loaded -->',
            'announcement_text' => '🔥 সারাদেশে ক্যাশ অন ডেলিভারি | ৪৮ ঘণ্টার মধ্যে নিশ্চিত হোম ডেলিভারি | ১০০% ক্যাশব্যাক গ্যারান্টি!',
        ];

        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }

        // 3. Categories (Organic, Home & Kitchen, Electronics)
        $catOrganic = Category::firstOrCreate(
            ['slug' => 'organic-products'],
            [
                'name' => 'অর্গানিক ফুড (Organic)',
                'image' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=800&auto=format&fit=crop&q=80',
                'icon' => 'Leaf',
                'description' => '১০০% ভেজালমুক্ত, খাঁটি ও প্রাকৃতিক পুষ্টিগুণে সমৃদ্ধ অর্গানিক পণ্যসমূহ।',
                'is_active' => true,
                'display_order' => 1,
            ]
        );

        $catKitchen = Category::firstOrCreate(
            ['slug' => 'home-kitchen'],
            [
                'name' => 'হোম ও কিচেন (Home & Kitchen)',
                'image' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?w=800&auto=format&fit=crop&q=80',
                'icon' => 'ChefHat',
                'description' => 'স্মার্ট কিচেন গ্যাজেট ও হোম এসেনশিয়াল আইটেম যা আপনার রান্না ও ঘরকে সহজ করবে।',
                'is_active' => true,
                'display_order' => 2,
            ]
        );

        $catElectronics = Category::firstOrCreate(
            ['slug' => 'electronics-gadgets'],
            [
                'name' => 'ইলেকট্রনিক্স ও গ্যাজেট (Electronics)',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&auto=format&fit=crop&q=80',
                'icon' => 'Zap',
                'description' => 'লেটেস্ট ট্রেন্ডিং গ্যাজেটস, স্মার্টওয়াচ, ট্রিমার ও আধুনিক টেক এক্সেসরিজ।',
                'is_active' => true,
                'display_order' => 3,
            ]
        );

        // 4. Products: Organic Products
        $honey = Product::firstOrCreate(
            ['slug' => 'sundarban-pure-raw-honey'],
            [
                'category_id' => $catOrganic->id,
                'name' => 'সুন্দরবনের ১০০% খাঁটি প্রাকৃতিক চাকের মধু (১ কেজি)',
                'sku' => 'ORG-HNY-01',
                'regular_price' => 1250.00,
                'sale_price' => 890.00,
                'stock' => 50,
                'thumbnail' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1587049352851-8d4e89133924?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1471943311424-646960669fbc?w=800&auto=format&fit=crop&q=80',
                ],
                'short_description' => 'সুন্দরবনের গভীর জঙ্গল থেকে সংগৃহীত সরাসরি মৌয়ালদের চাক ভাঙা কাঁচা মধু। কোনো প্রকার চিনি বা কেমিক্যাল মিশ্রিত নয়।',
                'description' => 'মধু হলো সর্বরোগের মহৌষধ। আমাদের সুন্দরবনের চাকের মধু সরাসরি সুন্দরবনের মৌয়ালদের হাত থেকে সংগৃহীত। এতে রয়েছে প্রাকৃতিক এনজাইম, পোলেন এবং ভিটামিন যা রোগ প্রতিরোধ ক্ষমতা বহুগুণ বৃদ্ধি করে এবং সর্দি-কাশি ও হজমের সমস্যা দূর করে।',
                'features' => [
                    '১০০% ভেজালমুক্ত সুন্দরবনের প্রাকৃতিক চাক ভাঙা মধু',
                    'কোনো প্রকার সুগার সিরাপ বা হিটিং প্রসেসিং মুক্ত',
                    'ল্যাব টেস্টে শতভাগ খাঁটি প্রমাণিত',
                    'ক্যাশ অন ডেলিভারিতে চেক করে মূল্য পরিশোধের সুযোগ',
                ],
                'is_active' => true,
                'is_featured' => true,
                'is_flash_deal' => true,
            ]
        );

        $oil = Product::firstOrCreate(
            ['slug' => 'cold-pressed-mustard-oil'],
            [
                'category_id' => $catOrganic->id,
                'name' => 'কাঠের ঘানি ভাঙা ১০০% খাঁটি সরিষার তেল (৫ লিটার)',
                'sku' => 'ORG-OIL-02',
                'regular_price' => 1750.00,
                'sale_price' => 1350.00,
                'stock' => 45,
                'thumbnail' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=800&auto=format&fit=crop&q=80',
                ],
                'short_description' => 'দেশি মাঘী সরিষা থেকে কাঠের ঘানিতে ভাঙানো ঝাঁঝালো ও সুগন্ধি খাঁটি সরিষার তেল।',
                'description' => 'সনাতন পদ্ধতিতে কাঠের ঘানিতে কম তাপমাত্রায় ভাঙানো সরিষার তেল যাতে সরিষার সকল প্রাকৃতিক ভিটামিন এবং আসল ঝাঁঝ অক্ষুণ্ণ থাকে। এটি রান্নার স্বাদ বাড়ায় এবং হার্ট সুস্থ রাখতে সাহায্য করে।',
                'features' => [
                    '১০০% খাঁটি দেশি হলুদ ও মাঘী সরিষা থেকে প্রস্তুত',
                    'কাঠের ঘানিতে কোল্ড প্রেসড পদ্ধতিতে তৈরি',
                    'কোন প্রকার কৃত্রিম রং ও কেমিক্যাল মুক্ত',
                    'তীব্র আসল ঝাঁঝ ও প্রাকৃতিক মিষ্টি সুবাস',
                ],
                'is_active' => true,
                'is_featured' => true,
                'is_flash_deal' => false,
            ]
        );

        $ghee = Product::firstOrCreate(
            ['slug' => 'premium-danader-ghee'],
            [
                'category_id' => $catOrganic->id,
                'name' => 'গাভীর খাঁটি দুধের সরের দানাদার প্রিমিয়াম গাওয়া ঘি (১ কেজি)',
                'sku' => 'ORG-GHEE-03',
                'regular_price' => 1950.00,
                'sale_price' => 1490.00,
                'stock' => 30,
                'thumbnail' => 'https://images.unsplash.com/photo-1628088062854-d1870b4553da?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1628088062854-d1870b4553da?w=800&auto=format&fit=crop&q=80',
                ],
                'short_description' => 'গ্রামের দেশি গাভীর দুধের সর থেকে ঐতিহ্যবাহী চুলার আঁচে তৈরি আসল দানাদার ঘি।',
                'description' => 'যেকোনো পোলাও, বিরিয়ানি বা গরম ভাতের সাথে এই দানাদার খাঁটি ঘি মুখের স্বাদ বাড়িয়ে দেবে শতগুণ। ১০০% বিশুদ্ধ ও কোনো কৃত্রিম গন্ধ মুক্ত।',
                'features' => [
                    'দেশি গরুর খাঁটি দুধের মাখন থেকে তৈরি',
                    'চমৎকার দানাদার টেক্সচার ও মন মাতানো সুবাস',
                    'স্মেল এনহ্যান্সার বা প্রিজারভেটিভ সম্পূর্ণ মুক্ত',
                ],
                'is_active' => true,
                'is_featured' => true,
                'is_flash_deal' => true,
            ]
        );

        // 5. Products: Home & Kitchen
        $chopper = Product::firstOrCreate(
            ['slug' => 'multi-function-vegetable-chopper'],
            [
                'category_id' => $catKitchen->id,
                'name' => '১২-ইন-১ মাল্টিফাংশন প্রিমিয়াম ভেজিটেবল ও ফ্রুট কাটার চপার',
                'sku' => 'KIT-CHOP-01',
                'regular_price' => 1350.00,
                'sale_price' => 790.00,
                'stock' => 120,
                'thumbnail' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?w=800&auto=format&fit=crop&q=80',
                ],
                'short_description' => 'রান্নার সময় বাঁচান নিমেষেই! পেঁয়াজ, আলু, সালাদ ও সবজি কাটুন মাত্র কয়েক সেকেন্ডে।',
                'description' => 'আল্ট্রা শার্প স্টেইনলেস স্টিল ব্লেড যুক্ত এই প্রিমিয়াম চপার দিয়ে যে কোনো শক্ত সবজি বা ফল নিমিষেই ডাইস, স্লাইস বা গ্রেট করে নিতে পারবেন। পরিষ্কার করাও অতি সহজ।',
                'features' => [
                    '১২টি ভিন্ন ধরনের ফুড-গ্রেড স্টেইনলেস স্টিল ব্লেড',
                    'বিপিএ-ফ্রি প্রিমিয়াম ডিউরেবল প্লাস্টিক বডি',
                    'হাত কাটার বা চোখে পেঁয়াজের ঝাঁঝ লাগার কোনো ঝুঁকি নেই',
                    'পানি দিয়ে সহজেই ওয়াশেবল',
                ],
                'is_active' => true,
                'is_featured' => true,
                'is_flash_deal' => true,
            ]
        );

        $blender = Product::firstOrCreate(
            ['slug' => 'portable-usb-mini-blender'],
            [
                'category_id' => $catKitchen->id,
                'name' => 'রিচার্জেবল পোর্টেবল ইউএসবি জুসার ও স্মুদি ব্লেন্ডার',
                'sku' => 'KIT-BLND-02',
                'regular_price' => 1200.00,
                'sale_price' => 690.00,
                'stock' => 85,
                'thumbnail' => 'https://images.unsplash.com/photo-1570222094114-d054a817e56b?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1570222094114-d054a817e56b?w=800&auto=format&fit=crop&q=80',
                ],
                'short_description' => 'যে কোনো জায়গায় তাজা জুস ও স্মুদি তৈরি করুন এই শক্তিশালী পোর্টেবল ব্লেন্ডার দিয়ে।',
                'description' => 'অফিস, জিম কিংবা ট্রাভেলের সময় ফ্রেশ ফ্রুট জুস বা প্রোটিন শেক বানাতে অতুলনীয়। ইউএসবি চার্জিং পোর্ট থাকায় পাওয়ার ব্যাংক বা মোবাইলের চার্জার দিয়ে চার্জ করা যায়।',
                'features' => [
                    '৬টি সুপার শার্প স্টেইনলেস স্টিল ব্লেড',
                    '২০০০ mAh দীর্ঘস্থায়ী রিচার্জেবল ব্যাটারি',
                    'সহজে বহনযোগ্য লাইটওয়েট স্লিম ডিজাইন',
                ],
                'is_active' => true,
                'is_featured' => false,
                'is_flash_deal' => false,
            ]
        );

        // 6. Products: Electronics & Gadgets
        $trimmer = Product::firstOrCreate(
            ['slug' => 't9-vintage-hair-beard-trimmer'],
            [
                'category_id' => $catElectronics->id,
                'name' => 'T9 প্রফেশনাল ভিন্টেজ মেটাল হেয়ার ও বিয়ার্ড ট্রিমার',
                'sku' => 'ELE-TRIM-01',
                'regular_price' => 1150.00,
                'sale_price' => 590.00,
                'stock' => 90,
                'thumbnail' => 'https://images.unsplash.com/photo-1621607512214-68297480165e?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1621607512214-68297480165e?w=800&auto=format&fit=crop&q=80',
                ],
                'short_description' => 'সেলুনের মতো নিখুঁত শেইপ ও ক্লিপিং ঘরে বসেই! ফুল মেটাল ভিন্টেজ এনগ্রেভড বডি।',
                'description' => 'টি-ব্লেড জিরো গ্যাপ ডিজাইনের কারণে স্ক্রিন বা স্কিনের কোনো ক্ষতি ছাড়াই নিঁখুত ট্রিম করা যায়। রিচার্জেবল ব্যাটারি দিয়ে একবার চার্জে টানা ১২০ মিনিট ব্যবহার করা সম্ভব।',
                'features' => [
                    'হেভি ডিউটি ড্রাগন/বুদ্ধা খোদাই করা এন্টিক মেটাল বডি',
                    'শার্প কার্বন-স্টিল টি-ব্লেড',
                    '৪টি ভিন্ন সাইজের লিমিট কম্ব (1.5mm, 2mm, 3mm, 4mm)',
                    'ইউএসবি ফাস্ট চার্জিং সাপোর্ট',
                ],
                'is_active' => true,
                'is_featured' => true,
                'is_flash_deal' => true,
            ]
        );

        $smartwatch = Product::firstOrCreate(
            ['slug' => 'ultra-smart-watch-with-calling'],
            [
                'category_id' => $catElectronics->id,
                'name' => 'Ultra 8 Series ওয়াটারপ্রুফ স্মার্ট ওয়াচ (ব্লুটুথ কলিং সহ)',
                'sku' => 'ELE-WCH-02',
                'regular_price' => 2450.00,
                'sale_price' => 1450.00,
                'stock' => 60,
                'thumbnail' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&auto=format&fit=crop&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&auto=format&fit=crop&q=80',
                ],
                'short_description' => '২.০২ ইঞ্চি এইচডি ডিসপ্লে, ফুল স্ক্রিন টাচ, ব্লুটুথ কলিং এবং হেলথ ট্র্যাকার।',
                'description' => 'সরাসরি ঘড়ি দিয়ে ফোন কল রিসিভ ও ডায়াল করার সুবিধা। হার্ট রেট, ব্লাড প্রেসার, স্লিপ মনিটরিং এবং স্পোর্টস মোড সহ প্রিমিয়াম মেটাল কেসিং।',
                'features' => [
                    'HD বেজেল-লেস ভাইব্র্যান্ট টাচ ডিসপ্লে',
                    'ব্লুটুথ কলিং ও সোশ্যাল মিডিয়া নোটিফিকেশন',
                    'IP68 ওয়াটার রেজিস্ট্যান্ট ও ডাস্ট প্রুফ',
                    'ওয়্যারলেস ম্যাগনেটিক চার্জিং',
                ],
                'is_active' => true,
                'is_featured' => true,
                'is_flash_deal' => false,
            ]
        );

        // 7. Landing Page Templates (Organic, Kitchen, Electronics)
        LandingPageTemplate::firstOrCreate(
            ['slug' => 'organic-food-sales-template'],
            [
                'name' => 'অর্গানিক খাঁটি পণ্য হাই-কনভার্টিং টেমপ্লেট',
                'category' => 'Organic',
                'thumbnail' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=600&auto=format&fit=crop&q=80',
                'content' => json_encode([
                    'headline' => 'প্রকৃতির আসল স্বাদ ও পুষ্টিতে ভরপুর খাঁটি খাবার!',
                    'subheadline' => 'ল্যাব টেস্টে শতভাগ খাঁটি প্রমাণিত, কোনো প্রকার ভেজাল পেলে পুরো টাকা ফেরত।',
                    'theme_color' => '#15803d',
                    'badge' => '🌿 ১০০% প্রিমিয়াম অর্গানিক পণ্য',
                ]),
                'custom_css' => '',
                'is_active' => true,
            ]
        );

        LandingPageTemplate::firstOrCreate(
            ['slug' => 'kitchen-viral-gadget-template'],
            [
                'name' => 'হোম ও কিচেন ভাইরাল গ্যাজেট টেমপ্লেট',
                'category' => 'Kitchen',
                'thumbnail' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?w=600&auto=format&fit=crop&q=80',
                'content' => json_encode([
                    'headline' => 'রান্নাঘরের কাজ সহজ করুন মাত্র চোখের পলকে!',
                    'subheadline' => 'হাজারো গৃহিণীদের পছন্দের স্মার্ট কিচেন টুল। কাটাকাটি এখন হবে আনন্দের।',
                    'theme_color' => '#c2410c',
                    'badge' => '🔥 রান্নাঘরের সেরা ভাইরাল গ্যাজেট',
                ]),
                'custom_css' => '',
                'is_active' => true,
            ]
        );

        LandingPageTemplate::firstOrCreate(
            ['slug' => 'electronics-offer-template'],
            [
                'name' => 'ইলেকট্রনিক্স ও টেক গ্যাজেট অফার টেমপ্লেট',
                'category' => 'Electronics',
                'thumbnail' => 'https://images.unsplash.com/photo-1621607512214-68297480165e?w=600&auto=format&fit=crop&q=80',
                'content' => json_encode([
                    'headline' => 'সেরা দামে অরিজিনাল গ্যাজেট সাথে ১ বছরের রিপ্লেসমেন্ট ওয়ারেন্টি!',
                    'subheadline' => 'স্টক সীমিত, এখনই বিশেষ ডিসকাউন্টে অর্ডার করুন ক্যাশ অন ডেলিভারিতে।',
                    'theme_color' => '#1d4ed8',
                    'badge' => '⚡ লিমিটেড টাইম মেগা ডিসকাউন্ট অফার',
                ]),
                'custom_css' => '',
                'is_active' => true,
            ]
        );

        // 8. Sample Landing Page for Honey (Organic)
        LandingPage::firstOrCreate(
            ['slug' => 'sundarban-honey-offer'],
            [
                'product_id' => $honey->id,
                'name' => 'সুন্দরবনের খাঁটি মধু স্পেশাল অফার পেজ',
                'builder_type' => 'visual',
                'status' => 'published',
                'seo_title' => 'সুন্দরবনের ১০০% খাঁটি চাকের মধু - স্পেশাল অফার',
                'seo_description' => 'সুন্দরবনের প্রাকৃতিক চাক ভাঙা খাঁটি মধু। ভেজাল প্রমাণে দ্বিগুণ মূল্য ফেরত। ক্যাশ অন ডেলিভারি।',
                'fb_pixel_id' => '123456789012345',
                'tiktok_pixel_id' => 'TT-DEMO-998877',
                'gtm_id' => 'GTM-DEMAND01',
                'views_count' => 140,
                'orders_count' => 18,
                'revenue_total' => 16020.00,
                'created_by' => $admin->id,
                'content' => json_encode([
                    [
                        'id' => 'sec_hero',
                        'type' => 'hero',
                        'badge' => '🌿 ১০০% প্রাকৃতিক সুন্দরবনের খাঁটি মধু',
                        'title' => 'প্রকৃতির আসল পুষ্টি ও ঔষধি গুণে ভরপুর সুন্দরবনের খাঁটি চাক ভাঙা মধু!',
                        'subtitle' => 'কোনো রকম চিনি বা কৃত্রিম মিষ্টি মুক্ত। সরাসরি মৌয়ালদের চাক ভাঙা মধু পৌঁছে দিচ্ছি আপনার ঘরে।',
                        'cta_text' => 'অর্ডার করতে এখানে চাপুন 🛒',
                        'bg_color' => '#064e3b',
                    ],
                    [
                        'id' => 'sec_urgency',
                        'type' => 'urgency',
                        'text' => '🔥 বিশেষ ছাড়ের অফার শেষ হতে বাকি:',
                        'hours' => '05',
                        'minutes' => '42',
                        'seconds' => '19',
                    ],
                    [
                        'id' => 'sec_why_buy',
                        'type' => 'features',
                        'title' => 'কেন আমাদের চাকের মধু অন্যদের চেয়ে সেরা?',
                        'items' => [
                            '১০০% প্রাকৃতিক চাক ভাঙা ফিল্টারড র’ মধু',
                            'কোনো প্রকার সুগার সিরাপ বা হিটিং প্রক্রিয়ামুক্ত',
                            'প্রাকৃতিক পোলেন ও অ্যান্টিঅক্সিডেন্টে ভরপুর',
                            'ডেলিভারি ম্যানের সামনে টেস্ট করে নেওয়ার পূর্ণ সুবিধা',
                        ],
                    ],
                    [
                        'id' => 'sec_order_form',
                        'type' => 'order_form',
                        'title' => 'অর্ডার কনফার্ম করতে নিচের সঠিক তথ্য পূরণ করুন',
                        'subtitle' => 'পণ্য হাতে পেয়ে চেক করে সম্পূর্ণ মূল্য পরিশোধ করার সুবিধা (Cash On Delivery)',
                    ],
                ]),
            ]
        );
    }
}
