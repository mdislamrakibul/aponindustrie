@extends('admin.layouts.app')

@section('title', 'Inventory Management')


@section('content')

    <style>
        .quantity-card {
            position: relative;
            background: #fff;
            border-radius: 18px;
            padding: 28px;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: .3s ease;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
            border: 1px solid #f1f5f9;
        }

        .quantity-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, .10);
        }

        .quantity-icon {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: #fff;
            flex-shrink: 0;
        }

        .quantity-content h3 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            color: #111827;
        }

        .quantity-content p {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 15px;
            font-weight: 500;
        }

        /* PRIMARY */
        .quantity-card-primary .quantity-icon {
            background: linear-gradient(135deg, #0d3b66, #1a5276);
        }

        /* SUCCESS */
        .quantity-card-success .quantity-icon {
            background: linear-gradient(135deg, #0d3b66, #1d6fa4);
        }

        /* WARNING */
        .quantity-card-warning .quantity-icon {
            background: linear-gradient(135deg, #d97706, #f59e0b);
        }

        .quantity-content h3 {
            color: #0d3b66;
        }

        .dash-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 14px rgba(13, 59, 102, .09);
            border: none;
            padding: 22px 20px;
            display: flex;
            align-items: center;
            gap: 18px;
            transition: transform .2s, box-shadow .2s;
            height: 100%;
        }

        .dash-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 28px rgba(13, 59, 102, .16);
        }

        .dash-icon {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            color: #fff;
            flex-shrink: 0;
        }

        .dash-icon.navy {
            background: linear-gradient(135deg, #0d3b66, #1a5276);
        }

        .dash-icon.red {
            background: linear-gradient(135deg, #c54836, #e05a44);
        }

        .dash-icon.amber {
            background: linear-gradient(135deg, #d97706, #f59e0b);
        }

        .dash-num {
            font-size: 2rem;
            font-weight: 800;
            color: #0d3b66;
            line-height: 1;
        }

        .dash-lbl {
            font-size: 0.8rem;
            color: #6b7280;
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .dash-icon.blue {
            background: linear-gradient(135deg, #0d3b66, #1d6fa4);
        }

        .dash-card:has(.dash-icon.navy) {
            background: linear-gradient(135deg, #e8f0f8, #dce8f4);
        }

        .dash-card:has(.dash-icon.blue) {
            background: linear-gradient(135deg, #ddeefa, #d0e8f8);
        }

        .dash-card:has(.dash-icon.red) {
            background: linear-gradient(135deg, #fce8e6, #fbd8d5);
        }

        .dash-card:has(.dash-icon.amber) {
            background: linear-gradient(135deg, #fef3dc, #fdecd0);
        }

        .quantity-card-primary {
            background: linear-gradient(135deg, #e8f0f8, #dce8f4);
        }

        .quantity-card-success {
            background: linear-gradient(135deg, #ddeefa, #d0e8f8);
        }

        .quantity-card-warning {
            background: linear-gradient(135deg, #fef3dc, #fdecd0);
        }
    </style>



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Inventory</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->




    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Product Stock Summary
                    </h3>
                </div>

                {{-- SUMMARY CARDS --}}

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6 mb-3">
                            <div class="dash-card">
                                <div class="dash-icon navy"><i class="fas fa-boxes"></i></div>
                                <div>
                                    <div class="dash-num">{{ $totalProducts }}</div>
                                    <div class="dash-lbl">Total Products</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 mb-3">
                            <div class="dash-card">
                                <div class="dash-icon blue"><i class="fas fa-check-circle"></i></div>
                                <div>
                                    <div class="dash-num">{{ $inStockProducts }}</div>
                                    <div class="dash-lbl">In Stock</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 mb-3">
                            <div class="dash-card">
                                <div class="dash-icon amber"><i class="fas fa-exclamation-triangle"></i></div>
                                <div>
                                    <div class="dash-num">{{ $lowStockProducts }}</div>
                                    <div class="dash-lbl">Low Stock</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 mb-3">
                            <div class="dash-card">
                                <div class="dash-icon red"><i class="fas fa-times-circle"></i></div>
                                <div>
                                    <div class="dash-num">{{ $outOfStockProducts }}</div>
                                    <div class="dash-lbl">Out of Stock</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <div class="card-title"> Product Quantity Summary</div>
                </div>
                <div class="card-body">
                    <div class="row mt-4">

                        {{-- TOTAL QUANTITY --}}
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="quantity-card quantity-card-primary"
                                style="box-shadow: 1px 1px 1px 1px #0d3b66 !important">
                                <div class="quantity-icon">
                                    <i class="fas fa-cubes"></i>
                                </div>
                                <div class="quantity-content">
                                    <h3>
                                        {{ $totalStockQuantity ?? 0 }}
                                    </h3>
                                    <p>
                                        Total Stock QTY
                                    </p>
                                </div>
                            </div>

                        </div>

                        {{-- IN STOCK --}}
                        <div class="col-lg-4 col-md-6 mb-4">

                            <div class="quantity-card quantity-card-success"
                                style="box-shadow: 1px 1px 1px 1px #1d6fa4 !important">

                                <div class="quantity-icon">
                                    <i class="fas fa-layer-group"></i>
                                </div>

                                <div class="quantity-content">

                                    <h3>
                                        {{ $inStockQuantity ?? 0 }}
                                    </h3>

                                    <p>
                                        Available Stock QTY
                                    </p>

                                </div>

                            </div>

                        </div>

                        {{-- LOW STOCK --}}
                        <div class="col-lg-4 col-md-6 mb-4">

                            <div class="quantity-card quantity-card-warning"
                                style="box-shadow: 1px 1px 1px 1px #d97706 !important">

                                <div class="quantity-icon">
                                    <i class="fas fa-exclamation"></i>
                                </div>

                                <div class="quantity-content">

                                    <h3>
                                        {{ $lowStockQuantity ?? 0 }}
                                    </h3>

                                    <p>
                                        Low Stock QTY
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            {{-- INVENTORY UPDATE --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Inventory Update
                    </h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('inventory.update') }}" method="POST">
                        @csrf

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="row">

                            {{-- Product Select --}}
                            <div class="col-md-4 mb-3">
                                <label class="font-weight-semibold">Product</label>
                                <select id="product_select" name="product_id" class="form-control" required>
                                    <option value="">— Select Product —</option>
                                    @foreach($products as $prod)
                                        <option value="{{ $prod->id }}" data-stock="{{ $prod->stock_quantity }}"
                                            data-purchase="{{ $prod->purchase_price }}"
                                            data-regularprice="{{ $prod->regular_price }}"
                                            data-perprice="{{ $prod->sale_price }}" data-minimum="{{ $prod->minimum_order }}"
                                            data-package="{{ $prod->package_price }}"
                                            data-tax="{{ $prod->tax_percentage ?? 0 }}"
                                            data-discount="{{ $prod->discount_value ?? 0 }}"
                                            data-discounttype="{{ $prod->discount_type ?? 'NONE' }}">
                                            {{ $prod->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Current Stock (readonly, just for reference) --}}
                            <div class="col-md-2 mb-3">
                                <label class="font-weight-semibold">
                                    Current Stock
                                    <small class="text-muted">()</small>
                                </label>
                                <input type="number" id="current_stock" class="form-control bg-light" readonly>
                            </div>

                            {{-- Add Stock --}}
                            <div class="col-md-2 mb-3">
                                <label class="font-weight-semibold">
                                    Add Stock
                                    <small class="text-muted">(Add stock)</small>
                                </label>
                                <input type="number" id="stock_quantity" name="stock_quantity" class="form-control" min="0"
                                    placeholder="0 ">
                            </div>

                            {{-- Minimum Order --}}
                            <div class="col-md-2 mb-3">
                                <label class="font-weight-semibold">Min. Order (pcs)</label>
                                <input type="number" id="minimum_order" name="minimum_order" class="form-control" min="1"
                                    placeholder="1" oninput="calcPackagePrice()" required>
                            </div>

                            {{-- Purchase Price --}}
                            <div class="col-md-2 mb-3">
                                <label class="font-weight-semibold">Purchase Price (৳)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">৳</span>
                                    </div>
                                    <input type="number" step="0.01" id="purchase_price" name="purchase_price"
                                        class="form-control" placeholder="0.00">
                                </div>
                            </div>

                            {{-- Regular Price --}}
                            <div class="col-md-2 mb-3">
                                <label class="font-weight-semibold">Regular Price (৳)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">৳</span>
                                    </div>
                                    <input type="number" step="0.01" id="regular_price" name="regular_price"
                                        class="form-control" placeholder="0.00">
                                </div>
                            </div>

                            {{-- Per Piece Price --}}
                            <div class="col-md-2 mb-3">
                                <label class="font-weight-semibold">Per Piece Price (৳)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">৳</span>
                                    </div>
                                    <input type="number" step="0.01" id="per_piece_price" name="per_piece_price"
                                        class="form-control" placeholder="0.00" oninput="calcPackagePrice()" required>
                                </div>
                            </div>

                            {{-- Package Price (auto calculated, readonly) --}}
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-semibold">
                                    Package Price (৳)
                                    <small class="text-muted">(auto)</small>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">৳</span>
                                    </div>
                                    <input type="number" step="0.01" id="package_price_preview"
                                        class="form-control bg-light" readonly placeholder="Per Piece × Min Order">
                                </div>
                                <small class="text-muted">Per Piece × Min Order</small>
                            </div>

                            {{-- Tax / VAT --}}
                            <div class="col-md-2 mb-3">
                                <label class="font-weight-semibold">Tax / VAT (%)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" id="tax_percentage" name="tax_percentage"
                                        class="form-control" placeholder="0" min="0" max="100" oninput="updateSummary()">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Discount Type --}}
                            <div class="col-md-2 mb-3">
                                <label class="font-weight-semibold">Discount Type</label>
                                <select name="discount_type" id="discount_type" class="form-control"
                                    onchange="updateSummary(); updateDiscountLabel()">
                                    <option value="NONE">No Discount</option>
                                    <option value="FLAT">Flat (৳)</option>
                                    <option value="PERCENTAGE">Percentage (%)</option>
                                </select>
                            </div>

                            {{-- Discount Value --}}
                            <div class="col-md-2 mb-3">
                                <label class="font-weight-semibold">
                                    Discount Value
                                    <span id="discount_unit" class="text-muted">(৳)</span>
                                </label>
                                <input type="number" step="0.01" id="discount_value" name="discount_value"
                                    class="form-control" placeholder="0" min="0" oninput="updateSummary()">
                            </div>

                            {{-- Live Summary Card --}}
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-semibold">Live Summary</label>
                                <div style="
                                                                                            background:#f8fafc;
                                                                                            border:1px solid #e2e8f0;
                                                                                            border-radius:8px;
                                                                                            padding:10px 14px;
                                                                                            font-size:13px;
                                                                                            line-height:24px;
                                                                                        ">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Package Price</span>
                                        <strong id="s_package">—</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Tax Amount</span>
                                        <strong id="s_tax" class="text-warning">—</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Discount</span>
                                        <strong id="s_discount" class="text-danger">—</strong>
                                    </div>
                                    <hr class="my-1">
                                    <div class="d-flex justify-content-between">
                                        <span style="color:#1a365d; font-weight:700;">Final Price</span>
                                        <strong id="s_final" style="color:#1a365d;">—</strong>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save mr-2"></i> Save Inventory
                        </button>

                    </form>

                </div>

            </div>

            {{-- INVENTORY LIST --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Inventory List
                    </h3>


                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap" id="dataTable">
                            <thead>
                                <tr>
                                    <th>SL.</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>SKU</th>
                                    <th>Stock</th>
                                    <th>Purchase Price</th>
                                    <th>Per Piece (৳)</th>
                                    <th>Package Price (৳)</th>
                                    <th>Min Order</th>
                                    <th>Tax %</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>
                                            {{ $product->name }}
                                        </td>

                                        <td>
                                            {{ $product->category->name ?? 'N/A' }}
                                        </td>

                                        <td>{{ $product->sku }}</td>

                                        <td>
                                            {{ $product->stock_quantity }}
                                        </td>

                                        <td>৳ {{ number_format($product->purchase_price, 2) }}</td>
                                        <td>৳ {{ number_format($product->sale_price, 2) }}</td>
                                        <td>৳ {{ number_format($product->package_price, 2) }}</td>
                                        <td>{{ $product->minimum_order }} pcs</td>
                                        <td>{{ $product->tax_percentage ?? 0 }}%</td>

                                        <td>
                                            @if($product->stock_quantity == 0)

                                                <span class="badge bg-danger">
                                                    Out of Stock
                                                </span>

                                            @elseif($product->stock_quantity >= 1 && $product->stock_quantity <= 99) <span
                                                    class="badge bg-warning text-dark">
                                                    Low Stock
                                                </span>

                                            @else

                                                <span class="badge bg-success">
                                                    In Stock
                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="6" class="text-center">
                                            No inventory products found.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const sel = document.getElementById('product_select');
            const curStock = document.getElementById('current_stock');
            const perPriceIn = document.getElementById('per_piece_price');
            const minOrderIn = document.getElementById('minimum_order');
            const pkgPreview = document.getElementById('package_price_preview');
            const taxIn = document.getElementById('tax_percentage');
            const discValIn = document.getElementById('discount_value');
            const discTypeIn = document.getElementById('discount_type');

            // ── Product select  ──
            sel.addEventListener('change', function () {
                const o = this.options[this.selectedIndex];
                if (!o.value) return;

                curStock.value = o.dataset.stock || '0';

                document.getElementById('purchase_price').value =
                    o.dataset.purchase || '';

                document.getElementById('regular_price').value =
                    o.dataset.regularprice || '';

                perPriceIn.value = o.dataset.perprice || '';
                minOrderIn.value = o.dataset.minimum || '';
                taxIn.value = o.dataset.tax || '0';
                discValIn.value = o.dataset.discount || '0';
                discTypeIn.value = o.dataset.discounttype || 'NONE';

                calcPackagePrice();
                updateDiscountLabel();
            });

        });

        // ── Package Price auto calculate ──
        // per_piece_price × minimum_order = package_price
        function calcPackagePrice() {
            const perPrice = parseFloat(document.getElementById('per_piece_price').value) || 0;
            const minOrder = parseInt(document.getElementById('minimum_order').value) || 1;
            const pkg = perPrice * minOrder;

            document.getElementById('package_price_preview').value =
                pkg > 0 ? pkg.toFixed(2) : '';

            updateSummary();
        }

        // ── Discount label update ──
        function updateDiscountLabel() {
            const type = document.getElementById('discount_type').value;
            document.getElementById('discount_unit').textContent =
                type === 'PERCENTAGE' ? '(%)' : '(৳)';
            updateSummary();
        }

        // ── Live Summary ──
        function updateSummary() {
            const perPrice = parseFloat(document.getElementById('per_piece_price').value) || 0;
            const minOrder = parseInt(document.getElementById('minimum_order').value) || 1;
            const taxPct = parseFloat(document.getElementById('tax_percentage').value) || 0;
            const discVal = parseFloat(document.getElementById('discount_value').value) || 0;
            const discType = document.getElementById('discount_type').value;

            const pkg = perPrice * minOrder;
            const taxAmt = (pkg * taxPct) / 100;

            let discAmt = 0;
            if (discType === 'FLAT') discAmt = discVal;
            if (discType === 'PERCENTAGE') discAmt = (pkg * discVal) / 100;

            const final = pkg + taxAmt - discAmt;

            document.getElementById('s_package').textContent = '৳ ' + pkg.toFixed(2);
            document.getElementById('s_tax').textContent = taxPct > 0 ? '+৳ ' + taxAmt.toFixed(2) : '—';
            document.getElementById('s_discount').textContent = discAmt > 0 ? '-৳ ' + discAmt.toFixed(2) : '—';
            document.getElementById('s_final').textContent = '৳ ' + final.toFixed(2);
        }
    </script>
@endpush