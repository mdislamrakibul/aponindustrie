@extends('admin.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card card-warning">

            <div class="card-header">
                <h3 class="card-title">Edit Salary</h3>
            </div>

            <form method="POST"
                  action="{{ route('admin.accounts.update', $account->id) }}">

                @csrf

                <div class="card-body">

                    {{-- Amount --}}
                    <div class="form-group">
                        <label>Amount</label>

                        <input type="number"
                               name="amount"
                               value="{{ $account->amount }}"
                               class="form-control">
                    </div>

                    {{-- Type --}}
                    <div class="form-group">
                        <label>Type</label>

                        <select name="type" class="form-control">

                            <option value="salary"
                                {{ $account->type == 'salary' ? 'selected' : '' }}>
                                Salary
                            </option>

                            <option value="bonus"
                                {{ $account->type == 'bonus' ? 'selected' : '' }}>
                                Bonus
                            </option>

                            <option value="advance"
                                {{ $account->type == 'advance' ? 'selected' : '' }}>
                                Advance
                            </option>

                        </select>
                    </div>

                    {{-- Note --}}
                    <div class="form-group">
                        <label>Note</label>

                        <textarea name="note"
                                  class="form-control"
                                  rows="4">{{ $account->note }}</textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit"
                            class="btn btn-warning">

                        Update Salary

                    </button>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection