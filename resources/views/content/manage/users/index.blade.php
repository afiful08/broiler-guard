@extends('layout.admin')

@section('title', 'Manage User | Broiler Guard')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title fw-semibold mb-4">Manage Users</h5>
                    <a href="{{ url('manage/users/create') }}" class="btn btn-primary">Add Users</a>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Avatar</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <th>
                                    <img src="@if ($item->avatar) {{ asset('storage/' . $item->avatar) }} @else {{ asset('images/profile/user-1.jpg') }} @endif"
                                        alt="" class="rounded-circle" style="width: 48px">
                                </th>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('manage.users.edit', $item->id) }}"
                                        class="btn btn-secondary me-2">Edit</a>
                                    <a href="{{ route('manage.users.destroy', $item->id) }}" class="btn btn-danger"
                                        data-confirm-delete="true">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
