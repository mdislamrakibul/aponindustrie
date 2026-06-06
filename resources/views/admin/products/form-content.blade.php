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

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Short Description
                            </label>

                            <textarea name="short_description" rows="4"
                                class="form-control rounded-3">{{ old('short_description', $isEdit ? $product->short_description : '') }}</textarea>

                            @error('short_description')

                                <small class="text-danger">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>

                        <div>
                            <label class="form-label fw-semibold">
                                Full Description
                            </label>

                            <textarea name="description" rows="7"
                                class="form-control rounded-3">{{ old('description', $isEdit ? $product->description : '') }}</textarea>

                            @error('description')

                                <small class="text-danger">
                                    {{ $message }}
                                </small>

                            @enderror

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
                                @error('name')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">
                                    Sale Price
                                </label>

                                <input type="number" name="sale_price" class="form-control rounded-3"
                                    value="{{ $isEdit ? $product->sale_price : '' }}">
                                @error('name')
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
                                @error('name')
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
                                @error('name')
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

                        <h5 class="fw-bold mb-4">
                            Product Image
                        </h5>

                        <div class="mb-3 text-center">

                            <img id="preview-image" src="{{ $image
    ? asset($image->file_path . $image->image_name)
    : asset('admin/no-image.png') }}" class="preview-image img-fluid rounded-4 border">

                        </div>

                        <input type="file" id="image-input" name="image" class="image-input form-control rounded-3">

                        @error('image')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

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
                            @error('name')
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
                                    'WEEKLY_FEATURED' => 'Weekly Featured',
                                    'HOT_SALE' => 'Hot Sale',
                                    'TOP_NEW' => 'Top New',
                                    'TOP_SELLING' => 'Top Selling',
                                    'TOP_RATED' => 'Top Rated',
                                ];
                            @endphp

                            @foreach($sections as $value => $label)

                                <div class="form-check">

                                    <input class="form-check-input" type="checkbox" name="featured_sections[]"
                                        value="{{ $value }}" {{ in_array($value, $featuredSections) ? 'checked' : '' }}>
                                    @error('name')
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

    $(document).on('change', '.image-input', function (e) {

        const file = e.target.files[0];

        if (!file) {
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {

            $('.preview-image').attr(
                'src',
                event.target.result
            );

        };

        reader.readAsDataURL(file);

    });

</script>