@extends('admin.layouts.app')

    @section('content')

        <div class="content p-3">

            <h1>Admin Dashboard</h1>

            <div class="card">

                <div class="card-body">

                    Welcome {{ Auth::user()->first_name }}

                </div>

            </div>

        </div>

@endsection