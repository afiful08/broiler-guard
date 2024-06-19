@extends('layout.admin')

@section('title', 'Manage User | Broiler Guard')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Users</h5>
            <form action="{{ route('manage.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="field-avatar" class="form-label">Avatar</label>
                    <input class="form-control @error('avatar') is-invalid @enderror" type="file" id="field-avatar"
                        name="avatar" accept="image/*">
                    @error('avatar')
                        <div id="field-avatarFeedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="field-name" class="form-label">Name</label>
                    <input type="name" class="form-control @error('name') is-invalid @enderror" id="field-name"
                        aria-describedby="field-nameFeedback" placeholder="John Doe" name="name"
                        value="{{ $user->name }}">
                    @error('name')
                        <div id="field-nameFeedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="field-email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="field-email"
                        aria-describedby="field-emailFeedback" placeholder="name@example.com" name="email"
                        value="{{ $user->email }}">
                    @error('email')
                        <div id="field-emailFeedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="field-password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        aria-describedby="field-passwordFeedback" id="field-password" name="password">
                    @error('password')
                        <div id="field-passwordFeedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="select-role" class="form-label">Role</label>
                    <select id="select-role" class="form-select" name="role">
                        @foreach ($roles as $item)
                            <option value="{{ $item->name }}" @if($user->roles->first()->name == $item->name) selected @endif>{{ Str::title($item->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary d-flex align-items-center">
                      <iconify-icon icon="solar:pen-linear" class="me-2" style="font-size:18px"></iconify-icon> Edit User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection