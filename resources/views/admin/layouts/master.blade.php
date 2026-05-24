@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show mx-3 mt-3">

        {{ session('success') }}

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"></button>

    </div>

@endif


@if ($errors->any())

    <div class="alert alert-danger mx-3 mt-3">

        <ul class="mb-0">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif