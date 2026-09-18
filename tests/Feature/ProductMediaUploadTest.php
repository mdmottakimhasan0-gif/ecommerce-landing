<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductMediaUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_view_product_create_page_with_product_media_section(): void
    {
        $admin = User::where('email', 'admin@demandhat.com')->first();

        $response = $this->actingAs($admin)->get(route('admin.products.create'));

        $response->assertStatus(200);
        $response->assertSee('Product Media');
        $response->assertSee('Main Thumbnail');
        $response->assertSee('Gallery Images');
        $response->assertDontSee('থাম্বনেইল ইমেজ URL');
        $response->assertDontSee('গ্যালারি ইমেজ URLs');
    }

    public function test_admin_can_create_product_by_uploading_thumbnail_and_gallery_files(): void
    {
        Storage::fake('public');

        $admin = User::where('email', 'admin@demandhat.com')->first();
        $category = Category::first();

        $thumbnailFile = UploadedFile::fake()->create('honey_thumb.jpg', 200, 'image/jpeg');
        $galleryFile1 = UploadedFile::fake()->create('honey_g1.jpg', 300, 'image/jpeg');
        $galleryFile2 = UploadedFile::fake()->create('honey_g2.jpg', 300, 'image/jpeg');

        $payload = [
            'category_id' => $category->id,
            'name' => 'খাঁটি সুন্দরবনের মধু ১ কেজি',
            'sku' => 'HONEY-001',
            'regular_price' => 1200,
            'sale_price' => 950,
            'stock' => 30,
            'thumbnail' => $thumbnailFile,
            'gallery' => [
                $galleryFile1,
                $galleryFile2,
            ],
            'short_description' => '১০০% প্রাকৃতিক সুন্দরবনের চাকের মধু।',
            'description' => 'বিশুদ্ধ প্রাকৃতিক মধু, কোন প্রিজারভেটিভ নেই।',
            'features_input' => "১০০% প্রাকৃতিক\nল্যাব পরীক্ষিত",
            'is_active' => '1',
        ];

        $response = $this->actingAs($admin)->post(route('admin.products.store'), $payload);

        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success');

        $product = Product::where('sku', 'HONEY-001')->first();
        $this->assertNotNull($product);
        $this->assertStringContainsString('/storage/products/', $product->thumbnail);
        $this->assertCount(2, $product->gallery);
        $this->assertStringContainsString('/storage/products/gallery/', $product->gallery[0]);
    }

    public function test_admin_can_update_product_with_new_thumbnail_and_additional_gallery(): void
    {
        Storage::fake('public');

        $admin = User::where('email', 'admin@demandhat.com')->first();
        $product = Product::first();

        $newThumb = UploadedFile::fake()->create('new_thumb.webp', 250, 'image/webp');
        $newGallery = UploadedFile::fake()->create('new_gal.jpg', 250, 'image/jpeg');

        $payload = [
            'category_id' => $product->category_id,
            'name' => $product->name,
            'sku' => $product->sku,
            'regular_price' => $product->regular_price,
            'sale_price' => $product->sale_price,
            'stock' => 25,
            'thumbnail' => $newThumb,
            'existing_gallery' => ['/storage/existing1.jpg'],
            'gallery' => [$newGallery],
        ];

        $response = $this->actingAs($admin)->put(route('admin.products.update', $product->id), $payload);

        $response->assertRedirect(route('admin.products.index'));

        $product->refresh();
        $this->assertStringContainsString('/storage/products/', $product->thumbnail);
        $this->assertCount(2, $product->gallery);
        $this->assertEquals('/storage/existing1.jpg', $product->gallery[0]);
        $this->assertStringContainsString('/storage/products/gallery/', $product->gallery[1]);
    }
}
