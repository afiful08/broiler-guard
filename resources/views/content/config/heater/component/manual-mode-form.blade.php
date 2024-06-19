<div class="mb-3 d-inline-flex flex-column">
    <label for="radio-switch" class="form-label">
        Switch on/off<br>
        <span class="text-body-secondary fw-normal fs-2">Manual Switch to turn the heater on and off</span>
    </label>
    <div class="btn-group" role="group" aria-label="Change mode" id="radio-switch">
        <input type="radio" class="btn-check" name="status" id="radio-switch1" autocomplete="off" value="0" @if(isset($config) && !$config->status) checked @endif>
        <label class="btn btn-outline-primary" for="radio-switch1">Off</label>

        <input type="radio" class="btn-check" name="status" id="radio-switch2" autocomplete="off" value="1" @if(isset($config) && $config->status) checked @endif>
        <label class="btn btn-outline-primary" for="radio-switch2">On</label>
    </div>
</div>
