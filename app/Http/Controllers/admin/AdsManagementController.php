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
            'image'          => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
            'text_top'       => 'nullable|string|max:255',
            'text_title'     => 'nullable|string|max:255',
            'text_highlight' => 'nullable|string|max:255',
            'text_sub'       => 'nullable|string|max:255',
        ]);

        $this->ensureUploadDir();

        $file     = $request->file('image');
        $fileName = time() . '_' . uniqid() . '.' . $file->extension();
        $file->move(public_path('uploads/ads/'), $fileName);

        $maxSort = Banner::where('type', 'SLIDER')->max('sort_order') ?? 0;

        Banner::create([
            'type'           => 'SLIDER',
            'slot'           => null,
            'label'          => 'Slider ' . ($maxSort + 1),
            'image_path'     => 'uploads/ads/' . $fileName,
            'rec_width'      => 980,
            'rec_height'     => 450,
            'sort_order'     => $maxSort + 1,
            'is_locked'      => false,
            'is_active'      => true,
            'text_top'       => $request->input('text_top') ?: null,
            'text_title'     => $request->input('text_title') ?: null,
            'text_highlight' => $request->input('text_highlight') ?: null,
            'text_sub'       => $request->input('text_sub') ?: null,
        ]);

        activityLog('Ads Management', 'CREATE', 'New slider image added');

        return redirect()->route('admin.ads.index')->with('success', 'New slide added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'text_top'       => 'nullable|string|max:255',
            'text_title'     => 'nullable|string|max:255',
            'text_highlight' => 'nullable|string|max:255',
            'text_sub'       => 'nullable|string|max:255',
        ]);

        $banner = Banner::findOrFail($id);

        $fields = [
            'text_top'       => $request->input('text_top') ?: null,
            'text_title'     => $request->input('text_title') ?: null,
            'text_highlight' => $request->input('text_highlight') ?: null,
            'text_sub'       => $request->input('text_sub') ?: null,
        ];

        if ($request->hasFile('image')) {
            if ($banner->image_path && str_starts_with($banner->image_path, 'uploads/ads/')) {
                $oldPath = public_path($banner->image_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $this->ensureUploadDir();

            $file                 = $request->file('image');
            $fileName             = time() . '_' . uniqid() . '.' . $file->extension();
            $file->move(public_path('uploads/ads/'), $fileName);
            $fields['image_path'] = 'uploads/ads/' . $fileName;
        }

        $banner->update($fields);

        activityLog('Ads Management', 'UPDATE', 'Slide updated: ' . $banner->label);

        return redirect()->route('admin.ads.index')->with('success', 'Slide updated successfully.');
    }

    public function removeText($id)
    {
        $banner = Banner::findOrFail($id);

        $banner->update([
            'text_top'       => null,
            'text_title'     => null,
            'text_highlight' => null,
            'text_sub'       => null,
        ]);

        activityLog('Ads Management', 'UPDATE', 'Removed slider text: ' . $banner->label);

        return redirect()->route('admin.ads.index')->with('success', 'Slide text removed for: ' . $banner->label);
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

    private function ensureUploadDir(): void
    {
        $dir = public_path('uploads/ads/');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
}
