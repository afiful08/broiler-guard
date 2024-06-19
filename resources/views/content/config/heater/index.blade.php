@extends('layout.admin')

@section('title', 'Heater Config | Broiler Guard')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Config Heater</h5>
                <form action="{{ route('config.heater.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="select-device" class="form-label">Device<br>
                            <span class="text-body-secondary fw-normal fs-2">Select the device whose configuration you want
                                to change.</span></label>
                        <select id="select-device" class="form-select" name="device_id" onchange="show(this.value)">
                            @foreach ($devices as $item)
                                <option value="{{ $item->id }}" @if ($loop->index == 0 || session('device_id') == $item->id) selected @endif>
                                    {{ $item->id }} - {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 d-inline-flex flex-column">
                        <label for="radio-mode" class="form-label">
                            Mode<br>
                            <span class="text-body-secondary fw-normal fs-2">Change the heater mode to manual or automatic.</span>
                        </label>
                        <div class="btn-group" role="group" aria-label="Change mode" id="radio-mode">
                            <input type="radio" class="btn-check" name="mode" id="radio-mode1" value="manual"
                                autocomplete="off" @if (isset($config) && $config->mode == 'MANUAL') checked @endif>
                            <label class="btn btn-outline-primary" for="radio-mode1">Manual</label>

                            <input type="radio" class="btn-check" name="mode" id="radio-mode2" value="automatic"
                                autocomplete="off" @if (isset($config) && $config->mode == 'AUTOMATIC') checked @endif>
                            <label class="btn btn-outline-primary" for="radio-mode2">Automatic</label>
                        </div>
                    </div>

                    <div id="mode-form">
                        @if (isset($config) && $config->mode == 'AUTOMATIC')
                            @include('content.config.heater.component.automatic-mode-form')
                        @elseif (isset($config) && $config->mode == 'MANUAL')
                            @include('content.config.heater.component.manual-mode-form')
                        @else
                            <p>No configuration available for the selected device.</p>
                        @endif
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
        $(document).ready(function() {
            $("[name=mode]").change(function() {
                let mode = $("[name=mode]:checked").val();
                console.log(mode);
                if (mode == 'manual') {
                    $('#mode-form').html(`@include('content.config.heater.component.manual-mode-form')`);
                } else {
                    $('#mode-form').html(`@include('content.config.heater.component.automatic-mode-form')`);
                }
            });
        });

        function show(id) {
            $.post("{{ route('config.heater.show') }}", {
                _token: '{{ csrf_token() }}',
                device_id: id
            }, function(response) {
                if (response.mode.toLowerCase() == 'automatic') {
                    $("input[name=mode][value='automatic']").prop("checked", true);
                    $('#mode-form').html(`@include('content.config.heater.component.automatic-mode-form')`);
                } else {
                    $("input[name=mode][value='manual']").prop("checked", true);
                    $('#mode-form').html(`@include('content.config.heater.component.manual-mode-form')`);
                }
                if (response.status == '1') {
                    $("input[name=status][value='1']").prop("checked", true);
                } else {
                    $("input[name=status][value='0']").prop("checked", true);
                }
                console.log(response);
            });
        }
    </script>
@endpush
