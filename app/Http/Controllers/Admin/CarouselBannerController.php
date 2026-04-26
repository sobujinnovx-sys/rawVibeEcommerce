<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarouselBannerRequest;
use App\Http\Requests\UpdateCarouselBannerRequest;
use App\Models\CarouselBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CarouselBannerController extends Controller
{
    public function index(): View
    {
        $banners = CarouselBanner::query()
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(10);

        return view('admin.carousel-banners.index', compact('banners'));
    }

    public function create(): View
    {
        return view('admin.carousel-banners.create');
    }

    public function store(StoreCarouselBannerRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['subtitle'] = filled($validated['subtitle'] ?? null) ? trim((string) $validated['subtitle']) : null;
        $validated['button_text'] = filled($validated['button_text'] ?? null) ? trim((string) $validated['button_text']) : null;
        $validated['button_link'] = filled($validated['button_link'] ?? null) ? trim((string) $validated['button_link']) : null;
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        CarouselBanner::query()->create($validated);

        return redirect()->route('admin.carousel-banners.index')->with('success', 'Carousel banner created successfully.');
    }

    public function edit(CarouselBanner $carouselBanner): View
    {
        return view('admin.carousel-banners.edit', ['banner' => $carouselBanner]);
    }

    public function update(UpdateCarouselBannerRequest $request, CarouselBanner $carouselBanner): RedirectResponse
    {
        $validated = $request->validated();
        $validated['subtitle'] = filled($validated['subtitle'] ?? null) ? trim((string) $validated['subtitle']) : null;
        $validated['button_text'] = filled($validated['button_text'] ?? null) ? trim((string) $validated['button_text']) : null;
        $validated['button_link'] = filled($validated['button_link'] ?? null) ? trim((string) $validated['button_link']) : null;
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($carouselBanner->image) {
                Storage::disk('public')->delete($carouselBanner->image);
            }
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        $carouselBanner->update($validated);

        return redirect()->route('admin.carousel-banners.index')->with('success', 'Carousel banner updated successfully.');
    }

    public function destroy(CarouselBanner $carouselBanner): RedirectResponse
    {
        if ($carouselBanner->image) {
            Storage::disk('public')->delete($carouselBanner->image);
        }

        $carouselBanner->delete();

        return redirect()->route('admin.carousel-banners.index')->with('success', 'Carousel banner deleted successfully.');
    }
}
