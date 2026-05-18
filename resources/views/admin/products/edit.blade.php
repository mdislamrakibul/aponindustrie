<div>
    @include('admin.products.form-content', [
        'isEdit' => true,
        'product' => $product,
        'categories' => $categories
    ])
</div>