<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdsManagementController extends Controller
{
    public function index()
    {
        $sliders = Banner::where('type', 'SLIDER')->orderBy('sort_order')->get();
        $banners = Banner::where('type', 'BANNER')->orderBy('sort_order')->get();

        return view('admin.ads.index', compact('sliders', 'banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $this->ensureUploadDir();

        $file     = $request->file('image');
        $fileName = time() . '_' . uniqid() . '.' . $file->extension();
        $file->move(public_path('uploads/ads/'), $fileName);

        $maxSort = Banner::where('type', 'SLIDER')->max('sort_order') ?? 0;

        Banner::create([
            'type'       => 'SLIDER',
            'slot'       => null,
            'label'      => 'Slider ' . ($maxSort + 1),
            'image_path' => 'uploads/ads/' . $fileName,
            'rec_width'  => 731,
            'rec_height' => 470,
            'sort_order' => $maxSort + 1,
            'is_locked'  => false,
            'is_active'  => true,
        ]);

        activityLog('Ads Management', 'CREATE', 'New slider image added');

        return redirect()->route('admin.ads.index')->with('success', 'New slide added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $banner = Banner::findOrFail($id);

        // Delete old file only if it was an admin-uploaded file
        if ($banner->image_path && str_starts_with($banner->image_path, 'uploads/ads/')) {
            $oldPath = public_path($banner->image_path);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $this->ensureUploadDir();

        $file     = $request->file('image');
        $fileName = time() . '_' . uniqid() . '.' . $file->extension();
        $file->move(public_path('uploads/ads/'), $fileName);

        $banner->update(['image_path' => 'uploads/ads/' . $fileName]);

        activityLog('Ads Management', 'UPDATE', 'Image replaced for: ' . $banner->label);

        return redirect()->route('admin.ads.index')->with('success', 'Image updated successfully.');
    }

    public function toggle($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->update(['is_active' => !$banner->is_active]);

        return redirect()->route('admin.ads.index')
            ->with('success', 'Status updated for: ' . $banner->label);
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->is_locked) {
            return redirect()->route('admin.ads.index')
                ->with('error', 'This slot cannot be deleted.');
        }

        if ($banner->image_path && str_starts_with($banner->image_path, 'uploads/ads/')) {
            $path = public_path($banner->image_path);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        activityLog('Ads Management', 'DELETE', 'Slider deleted: ' . $banner->label);
        $banner->delete();

        return redirect()->route('admin.ads.index')->with('success', 'Slide deleted.');
    }

    public function updateText(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $banner->update([
            'slide_top'       => $request->input('slide_top') ?: null,
            'slide_title'     => $request->input('slide_title') ?: null,
            'slide_highlight' => $request->input('slide_highlight') ?: null,
            'slide_desc'      => $request->input('slide_desc') ?: null,
            'hide_text'       => $request->boolean('hide_text'),
        ]);

        activityLog('Ads Management', 'UPDATE', 'Slide text updated: ' . $banner->label);

        return redirect()->route('admin.ads.index')->with('success', 'Slide text updated for: ' . $banner->label);
    }

    private function ensureUploadDir(): void
    {
        $dir = public_path('uploads/ads/');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
}
