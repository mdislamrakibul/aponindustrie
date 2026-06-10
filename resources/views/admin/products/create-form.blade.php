<!-- ADD PRODUCT MODAL -->

<div class="modal fade"
     id="addProductModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered"
         style="max-width:95%;">

        <div class="modal-content border-0 rounded-4 overflow-hidden">

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

            @include('admin.products.form-content', [
                'isEdit' => false,
                'product' => null
            ])

        </div>

    </div>

</div>


