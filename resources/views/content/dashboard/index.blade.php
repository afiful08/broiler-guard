@extends('layout.admin')

@section('title', 'Dashboard | Broiler Guard')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <!-- Temperature Card -->
            <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-6 mb-4 pb-3">
                            <span class="round-48 d-flex align-items-center justify-content-center rounded bg-danger-subtle">
                                <iconify-icon icon="solar:temperature-outline" class="fs-6 text-danger"></iconify-icon>
                            </span>
                            <h6 class="mb-0 fs-4">Temperature</h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-end mb-6">
                            <h6 class="mb-0 fw-medium">
                                <span id="temp-value">{{ $dataSensor->first()->temperature ?? 0 }}</span> °C
                            </h6>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100" style="height: 7px;">
                            <div class="progress-bar bg-danger" id="temp-bar"
                                style="width: {{ $dataSensor->first()->temperature ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Humidity Card -->
            <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-6 mb-4 pb-3">
                            <span class="round-48 d-flex align-items-center justify-content-center rounded bg-secondary-subtle">
                                <iconify-icon icon="solar:snowflake-outline" class="fs-6 text-secondary"></iconify-icon>
                            </span>
                            <h6 class="mb-0 fs-4">Humidity</h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-end mb-6">
                            <h6 class="mb-0 fw-medium">
                                <span id="humi-value">{{ $dataSensor->first()->humidity ?? 0 }}</span> %
                            </h6>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100" style="height: 7px;">
                            <div class="progress-bar bg-secondary" id="humi-bar"
                                style="width: {{ $dataSensor->first()->humidity ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Light Intensity Card -->
            <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-6 mb-4 pb-3">
                            <span class="round-48 d-flex align-items-center justify-content-center rounded bg-warning-subtle">
                                <iconify-icon icon="solar:lightbulb-outline" class="fs-6 text-warning"></iconify-icon>
                            </span>
                            <h6 class="mb-0 fs-4">Light Intensity</h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-end mb-6">
                            <h6 class="mb-0 fw-medium">
                                <span id="light-value">{{ $dataSensor->first()->light_intensity ?? 0 }}</span> lux
                            </h6>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100" style="height: 7px;">
                            <div class="progress-bar bg-warning" id="light-bar"
                                style="width: {{ $dataSensor->first()->light_intensity ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Heater and Lamp Status Cards -->
            <div class="col-lg-3">
                <div class="d-flex flex-column">
                    <!-- Heater Status -->
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-6">
                                <span class="round-48 d-flex align-items-center justify-content-center rounded bg-primary-subtle">
                                    <span class="fs-6 text-primary">ON</span>
                                </span>
                                <h6 class="mb-0 fs-4">Heater Status</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Lamp Status -->
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-6">
                                <span class="round-48 d-flex align-items-center justify-content-center rounded bg-danger-subtle">
                                    <span class="fs-6 text-danger">OFF</span>
                                </span>
                                <h6 class="mb-0 fs-4">Lamp Status</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sensor Statistics Chart -->
        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="card-title fw-semibold">Sensor Statistik</h5>
                            </div>
                        </div>
                        <div id="container"></div>
                    </div>
                </div>
            </div>
            <!-- Heater Activity Log -->
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="card-title fw-semibold">Heater Activity Log</h5>
                        </div>
                        <ul class="timeline-widget mb-0 position-relative mb-n5">
                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                <div class="timeline-time mt-n1 text-muted flex-shrink-0 text-end">09:46</div>
                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                    <span class="timeline-badge bg-primary flex-shrink-0 mt-2"></span>
                                </div>
                                <div class="timeline-desc fs-3 text-dark mt-n1">AUTOMATIC</div>
                            </li>
                            <!-- Additional Timeline Items Here -->
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Lamp Activity Log -->
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="card-title fw-semibold">Lamp Activity Log</h5>
                        </div>
                        <ul class="timeline-widget mb-0 position-relative mb-n5">
                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                <div class="timeline-time mt-n1 text-muted flex-shrink-0 text-end">09:46</div>
                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                    <span class="timeline-badge bg-primary flex-shrink-0 mt-2"></span>
                                </div>
                                <div class="timeline-desc fs-3 text-dark mt-n1">time_on = 07:00 ; time_off = 18:00</div>
                            </li>
                            <!-- Additional Timeline Items Here -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="py-6 px-6 text-center">
            <button id="toggle-demo">Toggle Demo Mode</button>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
    <script>
        let chart;
        let demoInterval;
        let demoMode = false;

        function getRandomFloat(min, max, decimals = 2) {
            const str = (Math.random() * (max - min) + min).toFixed(decimals);
            return parseFloat(str);
        }

        function updateDemoData() {
            const value = getRandomFloat(20, 30);
            const value1 = getRandomFloat(40, 60);
            const value2 = getRandomFloat(300, 800);

            document.getElementById("temp-value").innerHTML = value;
            document.getElementById("humi-value").innerHTML = value1;
            document.getElementById("light-value").innerHTML = value2;

            document.getElementById("temp-bar").style.width = value + "%";
            document.getElementById("humi-bar").style.width = value1 + "%";
            document.getElementById("light-bar").style.width = value2 + "%";

            const series = chart.series[0],
                series1 = chart.series[1],
                series2 = chart.series[2],
                shift = series.data.length > 20;

            const x = (new Date()).getTime();
            series.addPoint([x, value], true, shift);
            series1.addPoint([x, value1], true, shift);
            series2.addPoint([x, value2], true, shift);
        }

        function requestData(json) {
            const data = JSON.parse(json);
            const value = data.temperature;
            const value1 = data.humidity;
            const value2 = data.light_intensity;

            document.getElementById("temp-value").innerHTML = value;
            document.getElementById("humi-value").innerHTML = value1;
            document.getElementById("light-value").innerHTML = value2;

            document.getElementById("temp-bar").style.width = value + "%";
            document.getElementById("humi-bar").style.width = value1 + "%";
            document.getElementById("light-bar").style.width = value2 + "%";

            const series = chart.series[0],
                series1 = chart.series[1],
                series2 = chart.series[2],
                shift = series.data.length > 20;

            const x = (new Date()).getTime();
            series.addPoint([x, value], true, shift);
            series1.addPoint([x, value1], true, shift);
            series2.addPoint([x, value2], true, shift);
        }

        function initChart() {
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'container',
                    defaultSeriesType: 'spline',
                    events: {
                        load: function () {
                            setInterval(async function () {
                                if (!demoMode) {
                                    const response = await fetch('/path/to/your/api');
                                    const json = await response.json();
                                    requestData(json);
                                }
                            }, 1000);
                        }
                    }
                },
                title: {
                    text: 'Live Sensor Data'
                },
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 150,
                    maxZoom: 20 * 1000
                },
                yAxis: {
                    minPadding: 0.2,
                    maxPadding: 0.2,
                    title: {
                        text: 'Value',
                        margin: 80
                    }
                },
                series: [{
                    name: 'Temperature',
                    data: []
                }, {
                    name: 'Humidity',
                    data: []
                }, {
                    name: 'Light Intensity',
                    data: []
                }]
            });
        }

        function updateSeries() {
            fetch('/path/to/your/api')
                .then(response => response.json())
                .then(data => {
                    const value = data.temperature;
                    const value1 = data.humidity;
                    const value2 = data.light_intensity;

                    document.getElementById("temp-value").innerHTML = value;
                    document.getElementById("humi-value").innerHTML = value1;
                    document.getElementById("light-value").innerHTML = value2;

                    document.getElementById("temp-bar").style.width = value + "%";
                    document.getElementById("humi-bar").style.width = value1 + "%";
                    document.getElementById("light-bar").style.width = value2 + "%";

                    const series = chart.series[0],
                        series1 = chart.series[1],
                        series2 = chart.series[2],
                        shift = series.data.length > 20;

                    const x = (new Date()).getTime();
                    series.addPoint([x, value], true, shift);
                    series1.addPoint([x, value1], true, shift);
                    series2.addPoint([x, value2], true, shift);
                })
                .catch(error => {
                    console.error('Error updating series:', error);
                });
        }

        document.addEventListener('DOMContentLoaded', function () {
            initChart();

            const host = 'broker.emqx.io';
            const port = 8083;
            const clientId = 'mqttjs_' + Math.random().toString(16).substr(2, 8);

            const client = mqtt.connect(`ws://${host}:${port}/mqtt`, {
                clientId: clientId,
                keepalive: 60,
                reconnectPeriod: 1000,
                connectTimeout: 30 * 1000,
                clean: true,
                username: '',
                password: '',
                rejectUnauthorized: false
            });

            client.on('connect', function () {
                console.log('Connected');
                client.subscribe('/dashboard', function (err) {
                    if (!err) {
                        console.log('Subscribed to /dashboard');
                    }
                });
            });

            client.on('message', function (topic, message) {
                if (!demoMode) {
                    requestData(message.toString());
                }
            });

            document.getElementById('toggle-demo').addEventListener('click', function () {
                demoMode = !demoMode;
                if (demoMode) {
                    demoInterval = setInterval(updateDemoData, 1000);
                } else {
                    clearInterval(demoInterval);
                }
            });
        });
    </script>
@endpush
