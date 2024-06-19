<div class="row">
    <div class="col-md-6 col-sm-12 mb-3">
        <label for="range-mintemp" class="form-label">
            Minimum Temperature<br>
            <span class="text-body-secondary fw-normal fs-2">When the temperature reaches the
                <strong class="text-dark">minimum limit</strong>, the heater
                will turn <strong class="text-dark">on</strong>.</span>
        </label>
        <input type="range" class="form-range" 
            value="{{ isset($config) ? $config->min_temp : 0 }}" 
            min="0" max="50" step="1" 
            id="range-mintemp" name="min_temp"
            onInput="$('#mintemp-val').html($(this).val())">
        <span><span id="mintemp-val">{{ isset($config) ? $config->min_temp : 0 }}</span> °C</span>
    </div>

    <div class="col-md-6 col-sm-12 mb-3">
        <label for="range-maxtemp" class="form-label">
            Maximum Temperature<br>
            <span class="text-body-secondary fw-normal fs-2">When the temperature reaches the
                <strong class="text-dark">maximum limit</strong>, the heater
                will turn <strong class="text-dark">off</strong>.</span>
        </label>
        <input type="range" class="form-range" 
            value="{{ isset($config) ? $config->max_temp : 50 }}" 
            min="0" max="50" step="1" 
            id="range-maxtemp" name="max_temp"
            onInput="$('#maxtemp-val').html($(this).val())">
        <span><span id="maxtemp-val">{{ isset($config) ? $config->max_temp : 50 }}</span> °C</span>
    </div>
</div>
