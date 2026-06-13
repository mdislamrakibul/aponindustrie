@extends('admin.layouts.app')

@section('title', 'History Logs')


@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Activity History Logs</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<div class="card shadow-sm rounded-4">


    <div class="card-header bg-white">

        <h3 class="card-title">
            Activity History Logs
        </h3>

    </div>

    <div class="card-body table-responsive">

        <table class="table table-hover align-middle" id="dataTable">

            <thead class="table-light">

                <tr>

                    <th>SL.</th>

                    <th>Admin</th>

                    <th>Module</th>

                    <th>Action</th>

                    <th>Item</th>

                    <th>Details</th>

                    <th>Date & Time</th>

                </tr>

            </thead>

            <tbody>

                @forelse($logs as $log)

                <tr>

                    <td>
                        {{ $loop->iteration }}.
                    </td>

                    <td>
                        {{ $log->user->first_name ?? 'Unknown' }}
                    </td>

                    <td>

                        <span class="badge bg-primary px-3 py-2">

                            {{ $log->module }}

                        </span>

                    </td>

                    <td>

                        <span class="badge bg-dark px-3 py-2">

                            {{ $log->action }}

                        </span>

                    </td>

                    <td>

                        {{ $log->item }}

                    </td>

                    <td>

                        {{ $log->details }}

                    </td>

                    <td>

                        {{ $log->created_at->format('d M Y h:i A') }}

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="7" class="text-center py-5">

                        No Activity Found

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


@endsection
