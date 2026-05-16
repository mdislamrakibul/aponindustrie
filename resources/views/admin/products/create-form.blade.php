<!-- ADD PRODUCT MODAL -->

<div class="modal fade"
     id="addProductModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered"
     style="max-width: 95%;">

    <div class="modal-content"
         style="height: 95vh; overflow: hidden;">

        <div class="modal-header bg-white border-bottom">

            <h5 class="modal-title fw-bold">
                Add Product
            </h5>

            <button type="button"
                    class="close"
                    data-dismiss="modal">

                <span>&times;</span>

            </button>

        </div>

        <form method="POST"
              action="{{ route('admin.products.store') }}"
              enctype="multipart/form-data"
              style="height:100%;">

            @csrf

            <div class="modal-body bg-light"
                 style="
                    overflow-y: auto;
                    height: calc(95vh - 70px);
                    padding: 20px;
                 ">

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

                                                @foreach($categories as $category)

                                                    <option value="{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </option>

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
                                                    PUBLISHED
                                                </option>

                                                <option value="INACTIVE">
                                                    Inactive
                                                </option>

                                            </select>

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

            </div>

        </form>

    </div>

</div>

</div>
@push('scripts')

<script>

$('#image-input').on('change', function(e){

    let reader = new FileReader();

    reader.onload = function(event){

        $('#preview-image').attr('src', event.target.result);

    }

    reader.readAsDataURL(e.target.files[0]);

});

</script>

@endpush