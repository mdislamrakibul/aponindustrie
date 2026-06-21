@php

    $isEdit = $isEdit ?? false;

    $product = $product ?? null;

    $image = ($isEdit && $product)
        ? $product->media->first()
        : null;

    $featuredSections = (
        $isEdit &&
        $product &&
        $product->product_adv_type
    )
        ? json_decode($product->product_adv_type, true)
        : [];

@endphp

<form method="POST" action="{{ $isEdit
    ? route('admin.products.update', $product->id)
    : route('admin.products.store') }}" enctype="multipart/form-data">

    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="modal-body bg-light" style="max-height:75vh; overflow-y:auto;">

        <div class="row g-4">

            <!-- LEFT -->

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            Basic Information
                        </h5>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Product Name
                            </label>

                            <input type="text" name="name" class="form-control rounded-3" placeholder="Product Name"
                                value="{{ old('name', $isEdit && $product ? $product->name : '') }}">

                            @error('name')

                                <small class="text-danger">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>
                        <div class="row">

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">
                                    SKU (Stock Keeping Unit)
                                </label>

                                <input type="text" name="sku" class="form-control rounded-3"
                                    value="{{ old('sku', $isEdit && $product ? $product->sku : '') }}">

                                @error('sku')

                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                        </div>

                        {{-- SHORT DESCRIPTION --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Short Description
                                <span class="text-muted fw-normal" style="font-size:13px;">(Max 500 characters)</span>
                            </label>

                            @php $shortId = 'short_description_' . ($isEdit ? 'edit' : 'create'); @endphp
                            @php $shortCounterId = 'short_counter_' . ($isEdit ? 'edit' : 'create'); @endphp

                            <textarea name="short_description" id="{{ $shortId }}" rows="4" maxlength="500"
                                class="form-control rounded-3 @error('short_description') is-invalid @enderror"
                                oninput="updateCounter('{{ $shortId }}', '{{ $shortCounterId }}', 500)">{{ old('short_description', $isEdit ? ($product->short_description ?? '') : '') }}</textarea>

                            <div class="d-flex justify-content-between mt-1">
                                <div>
                                    @error('short_description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <small id="{{ $shortCounterId }}" style="font-size:12px; color:#6c757d;">
                                    {{ strlen(old('short_description', $isEdit ? ($product->short_description ?? '') : '')) }}
                                    / 500
                                </small>
                            </div>
                        </div>

                        {{-- FULL DESCRIPTION --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Full Description
                                <span class="text-muted fw-normal" style="font-size:13px;">(Max 5000 characters)</span>
                            </label>

                            @php $descId = 'description_' . ($isEdit ? 'edit' : 'create'); @endphp
                            @php $descCounterId = 'full_counter_' . ($isEdit ? 'edit' : 'create'); @endphp

                            <textarea name="description" id="{{ $descId }}" rows="7" maxlength="5000"
                                class="form-control rounded-3 @error('description') is-invalid @enderror"
                                oninput="updateCounter('{{ $descId }}', '{{ $descCounterId }}', 5000)">{{ old('description', $isEdit ? ($product->description ?? '') : '') }}</textarea>

                            <div class="d-flex justify-content-between mt-1">
                                <div>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <small id="{{ $descCounterId }}" style="font-size:12px; color:#6c757d;">
                                    {{ strlen(old('description', $isEdit ? ($product->description ?? '') : '')) }} /
                                    5000
                                </small>
                            </div>
                        </div>

                        {{-- ADDITIONAL INFO --}}
                        @php
                            $aiSuffix = $isEdit ? 'edit' : 'create';
                            // Build initial rows: old() on validation fail → saved JSON → one blank row
                            $aiRows = old('additional_info_rows');
                            if (!$aiRows) {
                                $saved = $isEdit ? ($product->additional_info ?? '') : '';
                                if ($saved) {
                                    $decoded = json_decode($saved, true);
                                    $aiRows  = is_array($decoded) ? $decoded : [];
                                }
                            }
                            if (empty($aiRows)) {
                                $aiRows = [['label' => '', 'value' => '']];
                            }
                        @endphp
                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label fw-semibold mb-0">Additional Info <span class="text-muted fw-normal" style="font-size:13px;">(Specifications table)</span></label>
                                <div class="form-check form-switch mb-0">
                                    <input type="hidden" name="additional_info_active" value="0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                           id="additionalInfoActive-{{ $aiSuffix }}" name="additional_info_active" value="1"
                                           {{ old('additional_info_active', $isEdit ? ($product->additional_info_active ?? false) : false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="additionalInfoActive-{{ $aiSuffix }}">Show on product page</label>
                                </div>
                            </div>

                            {{-- Column headers --}}
                            <div class="row g-2 mb-1 px-1">
                                <div class="col-5"><small class="fw-semibold text-muted">Info Title</small></div>
                                <div class="col-6"><small class="fw-semibold text-muted">Info Detail</small></div>
                            </div>

                            {{-- Repeater rows --}}
                            <div id="ai-rows-{{ $aiSuffix }}">
                                @foreach($aiRows as $i => $row)
                                <div class="row g-2 mb-2 ai-row">
                                    <div class="col-5">
                                        <input type="text"
                                               name="additional_info_rows[{{ $i }}][label]"
                                               class="form-control form-control-sm rounded-3"
                                               placeholder="e.g. Material"
                                               value="{{ $row['label'] ?? '' }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="text"
                                               name="additional_info_rows[{{ $i }}][value]"
                                               class="form-control form-control-sm rounded-3"
                                               placeholder="e.g. Polypropylene"
                                               value="{{ $row['value'] ?? '' }}">
                                    </div>
                                    <div class="col-1 d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger ai-rm-{{ $aiSuffix }}" title="Remove row">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <button type="button" id="ai-add-{{ $aiSuffix }}" class="btn btn-sm btn-outline-primary mt-1">
                                <i class="fas fa-plus me-1"></i> Add Additional Info Row
                            </button>
                        </div>
                    </div>

                </div>


                <div class="card border-0 shadow-sm rounded-4 mt-4">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            Pricing & Inventory
                        </h5>

                        <div class="row">

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">
                                    Regular Price
                                </label>

                                <input type="number" name="regular_price" class="form-control rounded-3"
                                    value="{{ $isEdit ? $product->regular_price : '' }}">
                                @error('regular_price')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">
                                    Per Product Price
                                </label>

                                <input type="number" name="sale_price" class="form-control rounded-3"
                                    value="{{ $isEdit ? $product->sale_price : '' }}">
                                @error('sale_price')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">
                                    Stock Quantity
                                </label>

                                <input type="number" name="stock_quantity" class="form-control rounded-3"
                                    value="{{ $isEdit ? $product->stock_quantity : '' }}">
                                @error('stock_quantity')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">
                                    Minimum Order
                                </label>

                                <input type="number" name="minimum_order" class="form-control rounded-3"
                                    value="{{ $isEdit ? $product->minimum_order : 1 }}">
                                @error('minimum_order')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                    </div>

                </div>

            </div>
            <!-- RIGHT -->

            <div class="col-lg-4">

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Product Images</h5>

                        @php
                            $images = ($isEdit && $product) ? $product->media->take(3) : collect();
                            $image1 = $images->get(0);
                            $image2 = $images->get(1);
                            $image3 = $images->get(2);
                            $suffix = $isEdit ? 'edit' : 'create';
                        @endphp

                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4">

                                <h5 class="fw-bold mb-4">Product Images</h5>

                                {{-- Image 1 --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Main Image
                                        @if(!$isEdit)<span class="text-danger">*</span>@endif
                                    </label>
                                    <div class="mb-2 text-center">
                                        <img id="preview-image-1-{{ $suffix }}" src="{{ $image1
    ? asset($image1->file_path . $image1->image_name)
    : asset('admin/no-image.png') }}" class="img-fluid rounded-4 border"
                                            style="max-height:160px; object-fit:cover; width:100%;">
                                    </div>
                                    <input type="file" name="image" class="form-control rounded-3"
                                        accept="image/jpg,image/jpeg,image/png,image/webp"
                                        onchange="previewImage(this, 'preview-image-1-{{ $suffix }}')">
                                    @error('image')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Image 2 --}}
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">
                                        Second Image
                                        <small class="text-muted">(optional)</small>
                                    </label>
                                    <div class="mb-2 text-center">
                                        <img id="preview-image-2-{{ $suffix }}" src="{{ $image2
    ? asset($image2->file_path . $image2->image_name)
    : asset('admin/no-image.png') }}" class="img-fluid rounded-4 border"
                                            style="max-height:160px; object-fit:cover; width:100%;">
                                    </div>
                                    <input type="file" name="image2" class="form-control rounded-3"
                                        accept="image/jpg,image/jpeg,image/png,image/webp"
                                        onchange="previewImage(this, 'preview-image-2-{{ $suffix }}')">
                                    @error('image2')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Image 3 --}}
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">
                                        Third Image
                                        <small class="text-muted">(optional)</small>
                                    </label>
                                    <div class="mb-2 text-center">
                                        <img id="preview-image-3-{{ $suffix }}" src="{{ $image3
    ? asset($image3->file_path . $image3->image_name)
    : asset('admin/no-image.png') }}" class="img-fluid rounded-4 border"
                                            style="max-height:160px; object-fit:cover; width:100%;">
                                    </div>
                                    <input type="file" name="image3" class="form-control rounded-3"
                                        accept="image/jpg,image/jpeg,image/png,image/webp"
                                        onchange="previewImage(this, 'preview-image-3-{{ $suffix }}')">
                                    @error('image3')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="card border-0 shadow-sm rounded-4 mt-4">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            Product Settings
                        </h5>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Category
                            </label>
                            <select name="category_id" class="form-select rounded-3">

                                <option value="">
                                    Select Category
                                </option>

                                @foreach($categories as $category)

                                    <option value="{{ $category->id }}" {{ $isEdit && $product->category_id == $category->id ? 'selected' : '' }}>

                                        {{ $category->name }}

                                    </option>

                                    @foreach($category->children as $child)

                                        <option value="{{ $child->id }}" {{ $isEdit && $product->category_id == $child->id ? 'selected' : '' }}>

                                            └── {{ $child->name }}

                                        </option>

                                    @endforeach

                                @endforeach

                            </select>
                            @error('category_id')

                                <small class="text-danger">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Status
                            </label>

                            <select name="status" class="form-select rounded-3">

                                <option value="PUBLISHED" {{ $isEdit && $product->status == 'PUBLISHED' ? 'selected' : '' }}>
                                    Published
                                </option>

                                <option value="INACTIVE" {{ $isEdit && $product->status == 'INACTIVE' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                                <option value="PENDING" {{ $isEdit && $product->status == 'PENDING' ? 'selected' : '' }}>
                                    Pending
                                </option>

                                <option value="DRAFT" {{ $isEdit && $product->status == 'DRAFT' ? 'selected' : '' }}>
                                    Draft
                                </option>

                            </select>

                        </div>
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Tags
                            </label>

                            <input type="text" name="tags" class="form-control rounded-3"
                                placeholder="kitchen, jar, plastic" value="{{ $isEdit ? $product->tags : '' }}">
                            @error('tags')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">

                            <label class="form-label fw-semibold d-block">
                                Featured Sections
                            </label>

                            @php
                                $sections = [
                                    'WEEKLYFEATURED' => 'Weekly Featured',
                                    'HOTSALEITEMS' => 'Hot Sale',
                                    'TOPNEWITEMS' => 'Top New',
                                    'TOPSELLING' => 'Top Selling',
                                    'TOPRATEDITEMS' => 'Top Rated',
                                ];
                            @endphp

                            @foreach($sections as $value => $label)

                                <div class="form-check">

                                    <input class="form-check-input" type="checkbox" name="featured_sections[]"
                                        value="{{ $value }}" {{ in_array($value, $featuredSections) ? 'checked' : '' }}>
                                    @error('featured_sections')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label class="form-check-label">
                                        {{ $label }}
                                    </label>

                                </div>

                            @endforeach

                        </div>
                        <button class="btn btn-dark w-100 rounded-3 py-3">

                            <i class="fas fa-save me-1"></i>
                            {{ $isEdit ? 'Update Product' : 'Save Product' }}

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</form>
<script>
    function previewImage(input, previewId) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.getElementById(previewId);
            if (img) img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    function updateCounter(fieldId, counterId, maxLength) {
        const field = document.getElementById(fieldId);
        const counter = document.getElementById(counterId);
        if (!field || !counter) return;
        const len = field.value.length;
        counter.textContent = len + ' / ' + maxLength;
        counter.style.color = len >= maxLength
            ? '#dc3545'
            : len >= maxLength * 0.9
                ? '#fd7e14'
                : '#6c757d';
    }

    // ── Additional Info row manager ──────────────────────────────────
    (function () {
        var sfx       = '{{ $aiSuffix }}';
        var container = document.getElementById('ai-rows-' + sfx);
        var addBtn    = document.getElementById('ai-add-' + sfx);
        if (!container || !addBtn) return;

        var rowIdx = {{ count($aiRows) }};

        addBtn.addEventListener('click', function () {
            var row = document.createElement('div');
            row.className = 'row g-2 mb-2 ai-row';
            row.innerHTML =
                '<div class="col-5"><input type="text" name="additional_info_rows[' + rowIdx + '][label]" class="form-control form-control-sm rounded-3" placeholder="e.g. Material"></div>' +
                '<div class="col-6"><input type="text" name="additional_info_rows[' + rowIdx + '][value]" class="form-control form-control-sm rounded-3" placeholder="e.g. Polypropylene"></div>' +
                '<div class="col-1 d-flex align-items-center"><button type="button" class="btn btn-sm btn-outline-danger ai-rm-' + sfx + '" title="Remove row"><i class="fas fa-times"></i></button></div>';
            container.appendChild(row);
            rowIdx++;
        });

        container.addEventListener('click', function (e) {
            var btn = e.target.closest('.ai-rm-' + sfx);
            if (!btn) return;
            var row  = btn.closest('.ai-row');
            var rows = container.querySelectorAll('.ai-row');
            if (rows.length > 1) {
                row.remove();
            } else {
                // keep at least one blank row
                row.querySelectorAll('input').forEach(function (inp) { inp.value = ''; });
            }
        });
    })();
    // ────────────────────────────────────────────────────────────────
</script>