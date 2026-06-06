<form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">

    @csrf

    <div class="row g-4">

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

                        <input type="text" name="name" class="form-control rounded-3"
                            value="{{ $isEdit ? $product->name : '' }}" </div>

                        <div class="row">

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">
                                    SKU
                                </label>

                                <input type="text" name="sku" class="form-control rounded-3"
                                    value="{{ $product->sku }}">

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">
                                    Barcode
                                </label>

                                <input type="text" name="barcode" class="form-control rounded-3"
                                    value="{{ $product->barcode }}">

                            </div>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Short Description
                            </label>

                            <textarea name="short_description" rows="4"
                                class="form-control rounded-3">{{ $product->short_description }}</textarea>

                        </div>

                        <div>

                            <label class="form-label fw-semibold">
                                Full Description
                            </label>

                            <textarea name="description" rows="7"
                                class="form-control rounded-3">{{ $isEdit ? $product->description : '' }}</textarea>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            Product Image
                        </h5>

                        @php
                            $image = $product->media->first();
                        @endphp

                        <img src="{{ $image ? asset($image->file_path . $image->image_name) : asset('admin/no-image.png') }}"
                            class="img-fluid rounded-4 border mb-3" style="height:250px;width:100%;object-fit:cover;">

                        <input type="file" name="image" class="form-control rounded-3">

                    </div>

                </div>

                <div class="card border-0 shadow-sm rounded-4 mt-4">

                    <div class="card-body p-4">

                        <button class="btn btn-dark w-100 rounded-3 py-3">

                            <i class="fas fa-save me-1"></i>
                            Update Product

                        </button>

                    </div>

                </div>

            </div>

        </div>

</form>