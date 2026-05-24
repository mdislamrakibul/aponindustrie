@php

$isEdit = $isEdit ?? false;

$product = $product ?? null;

$image = null;

if ($isEdit && $product && $product->media) {

    $image = $product->media->first();

}

$featuredSections = [];

if ($isEdit && $product && $product->product_adv_type) {

    $featuredSections = json_decode(
        $product->product_adv_type,
        true
    );

}

@endphp

<form method="POST"
      action="{{ $isEdit
            ? route('admin.products.update', $product->id)
            : route('admin.products.store') }}"
      enctype="multipart/form-data">

    @csrf

    <div class="modal-body bg-light"
         style="max-height:75vh; overflow-y:auto;">

        <div class="row g-4">

            <!-- LEFT -->

            <div class="col-lg-8">

                <!-- BASIC INFO -->

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            Basic Information
                        </h5>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Product Name
                            </label>

                            <input type="text"
                                name="name"
                                class="form-control rounded-3 @error('name') is-invalid @enderror"
                                placeholder="Product Name"
                                value="{{ old('name', $isEdit && $product ? $product->name : '') }}">

                            @error('name')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">
                                    SKU
                                </label>

                                <input type="text"
                                       name="sku"
                                       class="form-control rounded-3"
                                       value="{{ $isEdit ? $product->sku : '' }}">

                                @error('sku')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Short Description
                            </label>

                            <textarea
                                name="short_description"
                                rows="4"
                                class="form-control rounded-3">{{ $isEdit ? $product->short_description : '' }}</textarea>

                        </div>

                        <div>

                            <label class="form-label fw-semibold">
                                Full Description
                            </label>

                            <textarea
                                name="description"
                                rows="7"
                                class="form-control rounded-3">{{ $isEdit ? $product->description : '' }}</textarea>

                        </div>

                    </div>

                </div>


            </div>

            <!-- RIGHT -->

            <div class="col-lg-4">

                <!-- IMAGE -->

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            Product Image
                        </h5>

                        <div class="mb-3">

                            <img
                                src="{{ $image
                                    ? asset($image->file_path . '/' . $image->image_name)
                                    : asset('admin/no-image.png') }}"
                                class="preview-image img-fluid rounded-4 border"
                                style="height:250px;width:100%;object-fit:cover;">

                        </div>

                        <input type="file"
                            name="image"
                            class="image-input form-control rounded-3">

                    </div>

                </div>

                <!-- SETTINGS -->

                <div class="card border-0 shadow-sm rounded-4 mt-4">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            Product Settings
                        </h5>

                        <!-- CATEGORY -->

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Category
                            </label>

                            <select name="category_id"
                                    class="form-select rounded-3">

                                <option value="">
                                    Select Category
                                </option>

                                @foreach($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        {{ $isEdit && $product->category_id == $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>

                                    @foreach($category->children as $child)

                                        <option
                                            value="{{ $child->id }}"
                                            {{ $isEdit && $product->category_id == $child->id ? 'selected' : '' }}
                                        >
                                            └── {{ $child->name }}
                                        </option>

                                    @endforeach

                                @endforeach

                            </select>

                        </div>

                        <!-- STATUS -->

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Status
                            </label>

                            <select name="status"
                                    class="form-select rounded-3">

                                <option
                                    value="PUBLISHED"
                                    {{ ($isEdit && $product->status == 'PUBLISHED') || (!$isEdit) ? 'selected' : '' }}
                                >
                                    Published
                                </option>

                                <option
                                    value="INACTIVE"
                                    {{ $isEdit && $product->status == 'INACTIVE' ? 'selected' : '' }}
                                >
                                    Inactive
                                </option>

                                <option
                                    value="PENDING"
                                    {{ $isEdit && $product->status == 'PENDING' ? 'selected' : '' }}
                                >
                                    Pending
                                </option>

                                <option
                                    value="DRAFT"
                                    {{ $isEdit && $product->status == 'DRAFT' ? 'selected' : '' }}
                                >
                                    Draft
                                </option>

                            </select>

                        </div>

                        <!-- TAGS -->

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Tags
                            </label>

                            <input type="text"
                                   name="tags"
                                   class="form-control rounded-3"
                                   placeholder="kitchen, jar, plastic"
                                   value="{{ $isEdit ? $product->tags : '' }}">

                        </div>

                        <!-- FEATURED -->

                        <div class="mb-4">

                            <label class="form-label fw-semibold d-block">
                                Featured Sections
                            </label>

                            @php

                                $sections = [

                                    'WEEKLY_FEATURED' => 'Weekly Featured',
                                    'HOT_SALE' => 'Hot Sale',
                                    'TOP_NEW' => 'Top New',
                                    'TOP_SELLING' => 'Top Selling',
                                    'TOP_RATED' => 'Top Rated',

                                ];

                            @endphp

                            @foreach($sections as $value => $label)

                                <div class="form-check mb-2">

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="featured_sections[]"
                                        value="{{ $value }}"
                                        {{ in_array($value, $featuredSections) ? 'checked' : '' }}
                                    >

                                    <label class="form-check-label">

                                        {{ $label }}

                                    </label>

                                </div>

                            @endforeach

                        </div>

                        <button class="btn btn-dark w-100 rounded-3 py-3">

                            {{ $isEdit ? 'Update Product' : 'Save Product' }}

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</form>
