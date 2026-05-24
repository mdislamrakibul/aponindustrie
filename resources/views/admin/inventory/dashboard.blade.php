@extends('admin.layouts.app')

@section('content')


    <!-- Content Header -->

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1>Inventory Management</h1>
                </div>

            </div>

        </div>

    </section>

    <!-- Main content -->

    <section class="content">

        <div class="container-fluid">

            <!-- SUMMARY CARDS -->

            <div class="row">

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">

                        <div class="inner">
                            <h3>1250</h3>
                            <p>Total Inventory</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-boxes"></i>
                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">

                        <div class="inner">
                            <h3>25</h3>
                            <p>Total Categories</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-tags"></i>
                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">

                        <div class="inner">
                            <h3>$52K</h3>
                            <p>Total Stock Value</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-danger">

                        <div class="inner">
                            <h3>12</h3>
                            <p>Low Stock</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>

                    </div>

                </div>

            </div>

            

        </div>

    </section>



@endsection