<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPageTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TemplateController extends Controller
{
    public function index(): View
    {
        $templates = LandingPageTemplate::latest()->get();

        return view('admin.templates.index', compact('templates'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'thumbnail' => 'nullable|string|max:500',
            'content' => 'required',
        ]);

        $contentJson = is_array($request->content)
            ? json_encode($request->content)
            : (string) $request->content;

        LandingPageTemplate::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']).'-'.rand(100, 999),
            'category' => $validated['category'],
            'thumbnail' => $validated['thumbnail'] ?? null,
            'content' => $contentJson,
            'custom_css' => $request->custom_css ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('admin.templates.index')->with('success', 'টেমপ্লেট সফলভাবে সংরক্ষিত হয়েছে।');
    }

    public function destroy(LandingPageTemplate $template): RedirectResponse
    {
        $template->delete();

        return redirect()->route('admin.templates.index')->with('success', 'টেমপ্লেট মুছে ফেলা হয়েছে।');
    }
}
