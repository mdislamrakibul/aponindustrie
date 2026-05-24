@php
    $image = $product->media->first();
@endphp

<div class="row">

    <div class="col-md-4">

        <img
            src="{{ $image 
                ? asset($image->file_path . $image->image_name)
                : asset('admin/no-image.png') }}"
            class="img-fluid rounded-4 border">

    </div>

    <div class="col-md-8">

        <table class="table table-bordered">

            <tr>
                <th>Name</th>
                <td>{{ $product->name }}</td>
            </tr>

            <tr>
                <th>Category</th>
                <td>{{ $product->category->name ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th>Price</th>
                <td>৳ {{ $product->regular_price }}</td>
            </tr>

            <tr>
                <th>Sale Price</th>
                <td>৳ {{ $product->sale_price }}</td>
            </tr>

            <tr>
                <th>Stock</th>
                <td>{{ $product->stock_quantity }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>{{ $product->status }}</td>
            </tr>

            <tr>
                <th>SKU</th>
                <td>{{ $product->sku }}</td>
            </tr>

            <tr>
                <th>Short Description</th>
                <td>{{ $product->short_description }}</td>
            </tr>

            <tr>
                <th>Tags</th>
                <td>{{ $product->tags }}</td>
            </tr>

        </table>

    </div>

</div>