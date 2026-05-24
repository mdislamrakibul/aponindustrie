@extends('admin.layouts.app')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">Add Product</h4>

        <a href="{{ route('admin.products.index') }}"
           class="btn btn-secondary btn-sm">

            Back

        </a>

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('admin.products.store') }}"
              enctype="multipart/form-data">

            @csrf

            <div class="row">

                <div class="col-md-8">

                    <div class="form-group mb-3">

                        <label>Product Name</label>

                        <input type="text"
                               name="name"
                               class="form-control">

                    </div>

                    <div class="form-group mb-3">

                        <label>Description</label>

                        <textarea name="description"
                                  rows="5"
                                  class="form-control"></textarea>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-group mb-3">

                        <label>Product Image</label>

                        <input type="file"
                               class="form-control"
                               name="image">

                    </div>

                    <div class="form-group mb-3">

                        <label>Category</label>

                        <select name="category_id"
                                class="form-control">

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>

            <button class="btn btn-dark">

                Save Product

            </button>

        </form>

    </div>

</div>

@endsection
