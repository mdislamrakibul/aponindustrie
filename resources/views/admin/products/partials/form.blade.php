@php

$isEdit = isset($product);

@endphp
<form method="POST"
    action="{{ route('admin.products.store') }}"
    enctype="multipart/form-data">

    @csrf

    <div class="modal-body bg-light"
        style="max-height:75vh; overflow-y:auto;">

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

                            <input type="text"
                                name="name"
                                class="form-control rounded-3"
                                placeholder="Product Name">

                        </div>
                        <div class="row">

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">
                                    SKU
                                </label>

                                <input type="text"
                                    name="sku"
                                    class="form-control rounded-3">

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">
                                    Barcode
                                </label>

                                <input type="text"
                                    name="barcode"
                                    class="form-control rounded-3">

                            </div>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Short Description
                            </label>

                            <textarea
                                name="short_description"
                                rows="4"
                                class="form-control rounded-3"></textarea>

                        </div>

                        <div>
                            <label class="form-label fw-semibold">
                                Full Description
                            </label>

                            <textarea
                                name="description"
                                rows="7"
                                class="form-control rounded-3"></textarea>

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

                                <input type="number"
                                    name="regular_price"
                                    class="form-control rounded-3">

                            </div>
                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">
                                    Sale Price
                                </label>

                                <input type="number"
                                    name="sale_price"
                                    class="form-control rounded-3">

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">
                                    Stock Quantity
                                </label>

                                <input type="number"
                                    name="stock_quantity"
                                    class="form-control rounded-3">

                            </div>
                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">
                                    Minimum Order
                                </label>

                                <input type="number"
                                    name="minimum_order"
                                    class="form-control rounded-3"
                                    value="1">

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

                            <img
                                id="preview-image"
                                src="{{ asset('admin/no-image.png') }}"
                                class="img-fluid rounded-4 border"
                                style="height:250px;width:100%;object-fit:cover;">

                        </div>

                        <input type="file"
                            name="image"
                            id="image-input"
                            class="form-control rounded-3">

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
                            <select name="category_id"
                                    class="form-select rounded-3">

                                <option value="">
                                    Select Category
                                </option>

                                @foreach($categories as $category)

                                    <option value="{{ $category->id }}">

                                        {{ $category->name }}

                                    </option>

                                    @foreach($category->children as $child)

                                        <option value="{{ $child->id }}">

                                            └── {{ $child->name }}

                                        </option>

                                    @endforeach

                                @endforeach

                            </select>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Status
                            </label>

                            <select name="status"
                                    class="form-select rounded-3">

                                <option value="PUBLISHED">
                                    Published
                                </option>

                                <option value="INACTIVE">
                                    Inactive
                                </option>

                                <option value="PENDING">
                                    Pending
                                </option>

                                <option value="DRAFT">
                                    Draft
                                </option>

                            </select>

                        </div>
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Tags
                            </label>

                            <input type="text"
                                name="tags"
                                class="form-control rounded-3"
                                placeholder="kitchen, jar, plastic">

                        </div>
                        <div class="mb-4">

                            <label class="form-label fw-semibold d-block">
                                Featured Sections
                            </label>

                            <div class="form-check">

                                <input class="form-check-input"
                                    type="checkbox"
                                    name="featured_sections[]"
                                    value="WEEKLY_FEATURED">

                                <label class="form-check-label">
                                    Weekly Featured
                                </label>

                            </div>

                            <div class="form-check">

                                <input class="form-check-input"
                                    type="checkbox"
                                    name="featured_sections[]"
                                    value="HOT_SALE">

                                <label class="form-check-label">
                                    Hot Sale
                                </label>

                            </div>

                            <div class="form-check">

                                <input class="form-check-input"
                                    type="checkbox"
                                    name="featured_sections[]"
                                    value="TOP_NEW">

                                <label class="form-check-label">
                                    Top New
                                </label>

                            </div>

                            <div class="form-check">

                                <input class="form-check-input"
                                    type="checkbox"
                                    name="featured_sections[]"
                                    value="TOP_SELLING">

                                <label class="form-check-label">
                                    Top Selling
                                </label>

                            </div>

                            <div class="form-check">

                                <input class="form-check-input"
                                    type="checkbox"
                                    name="featured_sections[]"
                                    value="TOP_RATED">

                                <label class="form-check-label">
                                    Top Rated
                                </label>

                            </div>

                        </div>
                        <button class="btn btn-dark w-100 rounded-3 py-3">

                            <i class="fas fa-save me-1"></i>
                            Save Product

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</form>