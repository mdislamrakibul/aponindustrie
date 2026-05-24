@extends('admin.layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h3 class="fw-bold">
        Activity History Logs
    </h3>

</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body table-responsive p-0">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th>ID</th>

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
                        {{ $log->id }}
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

<div class="mt-4">

    {{ $logs->links('pagination::bootstrap-4') }}

</div>

@endsection