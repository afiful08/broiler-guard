@extends('layout.admin')

@section('title', 'Manage Device | Broiler Guard')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Edit Device</h5>
                <form action="{{ route('manage.devices.update', $device->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="{{$device->id}}">
                    <div class="mb-3">
                        <label for="field-id" class="form-label">Device ID</label>
                        <div class="input-group has-validation" data-bs-toggle="tooltip"
                            data-bs-title="Device ID not allowed to edit">
                            <input type="text" class="form-control @error('id') is-invalid @enderror" id="field-id"
                                aria-describedby="btnDeviceID" placeholder="Ex: AB0001" name="id"
                                value="{{ $device->id }}" maxlength="6" readonly disabled>
                            <button class="btn btn-outline-dark" type="button" id="btnDeviceID"
                                onclick="generateRandomString('#field-id')" disabled>Generate ID</button>
                                @error('id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="select-user" class="form-label">Owned by</label>
                        <select id="select-user" class="form-select" name="user_id">
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}" @if ($device->user_id == $item->id) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="field-name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="field-name"
                            aria-describedby="field-nameFeedback" placeholder="Ex: Kandang Ayam Umur 7 - 14 Hari"
                            name="name" value="{{ $device->name }}">
                        @error('name')
                            <div id="field-nameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary d-flex align-items-center">
                            <iconify-icon icon="solar:pen-linear" class="me-2" style="font-size:18px"></iconify-icon>
                            Edit Device</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endpush
