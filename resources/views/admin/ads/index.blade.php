@extends('admin.layouts.app')

@section('title', 'Ads Management')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ads Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Ads Management</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            {{-- ══════════════════════════════════════════ --}}
            {{-- SLIDERS SECTION --}}
            {{-- ══════════════════════════════════════════ --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h3 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-sliders-h mr-2 text-primary"></i>
                        Hero Sliders
                    </h3>
                    <small class="text-muted ml-2">Recommended size: 731 × 470 px</small>
                </div>
                <div class="card-body">

                    {{-- Add New Slide --}}
                    <div class="card border mb-4" style="background:#f8f9fa;">
                        <div class="card-body py-3">
                            <h6 class="font-weight-bold mb-3">
                                <i class="fas fa-plus-circle mr-1 text-success"></i> Add New Slide
                                <small class="text-muted font-weight-normal">(Recommended: 731 × 470 px)</small>
                            </h6>
                            <form method="POST" action="{{ route('admin.ads.store') }}" enctype="multipart/form-data"
                                  class="d-flex align-items-center gap-3 flex-wrap">
                                @csrf
                                <input type="file" name="image" accept="image/jpg,image/jpeg,image/png,image/webp"
                                       class="form-control" style="max-width:320px;" required>
                                @error('image')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <button type="submit" class="btn btn-success ml-2">
                                    <i class="fas fa-upload mr-1"></i> Upload & Add
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Slider grid --}}
                    <div class="row">
                        @foreach($sliders as $slider)
                            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                <div class="card border h-100">
                                    {{-- Preview --}}
                                    <div style="height:160px;overflow:hidden;border-radius:4px 4px 0 0;background:#eee;position:relative;">
                                        <img id="ads-preview-{{ $slider->id }}"
                                             src="{{ asset($slider->image_path) }}"
                                             alt="{{ $slider->label }}"
                                             style="width:100%;height:160px;object-fit:cover;display:block;transition:opacity .2s;">
                                        <div id="ads-overlay-{{ $slider->id }}" style="display:none;position:absolute;inset:0;background:rgba(0,0,0,.45);color:#fff;font-size:12px;font-weight:600;align-items:center;justify-content:center;">
                                            <i class="fas fa-image mr-1"></i> New image selected
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="font-weight-bold text-truncate" style="max-width:120px;"
                                                  title="{{ $slider->label }}">
                                                {{ $slider->label }}
                                            </span>
                                            @if($slider->is_locked)
                                                <span class="badge badge-secondary">Protected</span>
                                            @endif
                                        </div>
                                        <small class="text-muted d-block mb-2">
                                            Rec: 731 × 470 px &bull;
                                            <span class="{{ $slider->is_active ? 'text-success' : 'text-danger' }}">
                                                {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </small>

                                        {{-- Replace form --}}
                                        <form method="POST" action="{{ route('admin.ads.update', $slider->id) }}"
                                              enctype="multipart/form-data" class="mb-2">
                                            @csrf
                                            <div class="input-group input-group-sm">
                                                <input type="file" name="image"
                                                       accept="image/jpg,image/jpeg,image/png,image/webp"
                                                       class="form-control form-control-sm" required
                                                       onchange="adsPreview(this,'{{ $slider->id }}')">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="Update Image" data-toggle="tooltip" data-placement="top">
                                                        <i class="fas fa-sync-alt"></i> Update
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        {{-- Toggle + Delete row --}}
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <form method="POST" action="{{ route('admin.ads.toggle', $slider->id) }}">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-sm {{ $slider->is_active ? 'btn-warning' : 'btn-success' }}">
                                                    {{ $slider->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>

                                            @if(!$slider->is_locked)
                                                <form method="POST" action="{{ route('admin.ads.destroy', $slider->id) }}"
                                                      onsubmit="return confirm('Delete this slide?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        {{-- Edit slide text --}}
                                        <button type="button"
                                                class="btn btn-sm btn-outline-info w-100 mt-2"
                                                onclick="openTextModal(
                                                    {{ $slider->id }},
                                                    {{ json_encode($slider->slide_top ?? '') }},
                                                    {{ json_encode($slider->slide_title ?? '') }},
                                                    {{ json_encode($slider->slide_highlight ?? '') }},
                                                    {{ json_encode($slider->slide_desc ?? '') }},
                                                    {{ $slider->hide_text ? 'true' : 'false' }}
                                                )">
                                            <i class="fas fa-pen mr-1"></i> Edit Text
                                        </button>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            {{-- ══════════════════════════════════════════ --}}
            {{-- BANNERS SECTION --}}
            {{-- ══════════════════════════════════════════ --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h3 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-image mr-2 text-warning"></i>
                        Static Banners
                    </h3>
                    <small class="text-muted ml-2">Fixed slots — replace image only</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($banners as $banner)
                            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                                <div class="card border h-100">
                                    {{-- Preview --}}
                                    <div style="height:160px;overflow:hidden;border-radius:4px 4px 0 0;background:#eee;position:relative;">
                                        <img id="ads-preview-{{ $banner->id }}"
                                             src="{{ asset($banner->image_path) }}"
                                             alt="{{ $banner->label }}"
                                             style="width:100%;height:160px;object-fit:cover;display:block;transition:opacity .2s;">
                                        <div id="ads-overlay-{{ $banner->id }}" style="display:none;position:absolute;inset:0;background:rgba(0,0,0,.45);color:#fff;font-size:12px;font-weight:600;align-items:center;justify-content:center;">
                                            <i class="fas fa-image mr-1"></i> New image selected
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="font-weight-bold mb-1">{{ $banner->label }}</div>
                                        <small class="text-muted d-block mb-2">
                                            Rec: {{ $banner->rec_width }} × {{ $banner->rec_height }} px &bull;
                                            <span class="{{ $banner->is_active ? 'text-success' : 'text-danger' }}">
                                                {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </small>

                                        {{-- Replace form --}}
                                        <form method="POST" action="{{ route('admin.ads.update', $banner->id) }}"
                                              enctype="multipart/form-data" class="mb-2">
                                            @csrf
                                            <div class="input-group input-group-sm">
                                                <input type="file" name="image"
                                                       accept="image/jpg,image/jpeg,image/png,image/webp"
                                                       class="form-control form-control-sm" required
                                                       onchange="adsPreview(this,'{{ $banner->id }}')">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="Update Image" data-toggle="tooltip" data-placement="top">
                                                        <i class="fas fa-sync-alt"></i> Update
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        {{-- Toggle --}}
                                        <form method="POST" action="{{ route('admin.ads.toggle', $banner->id) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-sm {{ $banner->is_active ? 'btn-warning' : 'btn-success' }} w-100">
                                                {{ $banner->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ── Slide Text Edit Modal ── --}}
    <div class="modal fade" id="slideTextModal" tabindex="-1" role="dialog" aria-labelledby="slideTextModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="slideTextModalLabel">
                        <i class="fas fa-pen mr-2 text-info"></i>Edit Slide Text
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="slideTextForm">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted small mb-3">
                            Leave any field blank to fall back to the default text on the live site.
                        </p>
                        <div class="form-group">
                            <label class="font-weight-bold">Top Label</label>
                            <small class="text-muted d-block mb-1">Small line above the main title — e.g. "Trade-in offer"</small>
                            <input type="text" name="slide_top" id="modalSlideTop"
                                   class="form-control" placeholder="Trade-in offer" maxlength="100">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Title</label>
                            <small class="text-muted d-block mb-1">Medium heading — e.g. "Supper deals"</small>
                            <input type="text" name="slide_title" id="modalSlideTitle"
                                   class="form-control" placeholder="Supper deals" maxlength="100">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Highlight</label>
                            <small class="text-muted d-block mb-1">Large green heading — e.g. "On all products"</small>
                            <input type="text" name="slide_highlight" id="modalSlideHighlight"
                                   class="form-control" placeholder="On all products" maxlength="100">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Description</label>
                            <small class="text-muted d-block mb-1">Subtext below headings — e.g. "Save more with coupons & up to 70% off"</small>
                            <input type="text" name="slide_desc" id="modalSlideDesc"
                                   class="form-control" placeholder="Save more with coupons & up to 70% off" maxlength="200">
                        </div>
                        <div class="form-group mb-0">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="hide_text" id="modalHideText" value="1">
                                <label class="custom-control-label font-weight-bold" for="modalHideText">
                                    Hide text — show image only
                                </label>
                            </div>
                            <small class="text-muted">When enabled, all text is hidden and only the slider image is shown.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save Text
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function openTextModal(id, top, title, highlight, desc, hideText) {
        document.getElementById('slideTextForm').action      = '/admin/ads/' + id + '/text';
        document.getElementById('modalSlideTop').value       = top       || '';
        document.getElementById('modalSlideTitle').value     = title     || '';
        document.getElementById('modalSlideHighlight').value = highlight || '';
        document.getElementById('modalSlideDesc').value      = desc      || '';
        document.getElementById('modalHideText').checked     = !!hideText;
        $('#slideTextModal').modal('show');
    }
    </script>

    <script>
    function adsPreview(input, id) {
        if (!input.files || !input.files[0]) return;
        var reader = new FileReader();
        reader.onload = function (e) {
            var img     = document.getElementById('ads-preview-' + id);
            var overlay = document.getElementById('ads-overlay-' + id);
            if (img) {
                img.src = e.target.result;
                img.style.opacity = '1';
            }
            if (overlay) {
                overlay.style.display = 'flex';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
    </script>

@endsection
