@extends('layouts.app')

@section('body')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">List currencies</h1>
        <a href="{{ route('currencies.create') }}" class="btn btn-primary">Add</a>
    </div>
    <hr />
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Symbol</th>
                <th>Decimal Digits</th>
                <th>Virtual</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($currencies->count() > 0)
                @foreach ($currencies as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->name }}</td>
                        <td class="align-middle">{{ $rs->symbol }}</td>
                        <td class="align-middle">{{ $rs->decimal_digits }}</td>
                        <td class="align-middle">{{ $rs->is_virtual ? 'Yes' : 'No' }}</td>
                        <td class="align-middle">{{ $rs->is_status ? 'activated' : 'inactive' }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('currencies.show', $rs->id) }}" type="button"
                                    class="btn btn-secondary">Detail</a>
                                <a href="{{ route('currencies.edit', $rs->id) }}" type="button"
                                    class="btn btn-warning">Edit</a>
                                <form action="{{ route('currencies.destroy', $rs->id) }}" method="POST" type="button"
                                    class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5"> not found</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection
