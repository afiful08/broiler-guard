@extends('layout.admin')

@section('title', 'Lamp Config | Broiler Guard')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Config Lamp</h5>
                <form action="{{ route('config.lamp.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="select-device" class="form-label">Device<br>
                            <span class="text-body-secondary fw-normal fs-2">Select the device whose configuration you want to change.</label>
                        <select id="select-device" class="form-select" name="device_id" onchange="show(this.value)">
                            @foreach ($devices as $item)
                                <option value="{{ $item->id }}" @if ($loop->index == 0  || session('device_id') == $item->id) selected @endif>
                                    {{ $item->id }} - {{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="field-timeon" class="form-label">Time On</label>
                            <input type="time" class="form-control @error('time_on') is-invalid @enderror"
                                id="field-timeon" aria-describedby="field-timeonFeedback" name="time_on"
                                value="{{ old('time_on') ?? ($config->time_on ?? '') }}" onfocus="this.showPicker()">
                            @error('time_on')
                                <div id="field-timeonFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="field-timeoff" class="form-label">Time Off</label>
                            <input type="time" class="form-control @error('time_off') is-invalid @enderror"
                                id="field-timeoff" aria-describedby="field-timeoffFeedback" name="time_off"
                                value="{{ old('time_off') ?? ($config->time_off ?? '') }}" onfocus="this.showPicker()">
                            @error('time_off')
                                <div id="field-timeoffFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary d-flex align-items-center">
                            <iconify-icon icon="solar:settings-bold" class="me-2" style="font-size:18px"></iconify-icon>
                            Update Configuration</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function show(id) {
            $.post("{{ route('config.lamp.show') }}", {
                _token: '{{ csrf_token() }}',
                device_id: id
            }, function(response) {
                $("input[name=time_on]").val(response.time_on);
                $("input[name=time_off]").val(response.time_off);
            });
        }
    </script>
@endpush