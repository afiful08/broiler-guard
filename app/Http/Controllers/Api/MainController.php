<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\ConfigHeater;
use App\Models\ConfigLamp;
use App\Models\DataSensor;
use PhpMqtt\Client\Facades\MQTT;

class MainController extends Controller
{
    // [Get] configuration from actuator
    public function get_config($deviceId)
    {
        $device = Device::find($deviceId);
        $configHeater = ConfigHeater::where('device_id', $deviceId)->first();
        $configLamp = ConfigLamp::where('device_id',$deviceId)->first();
        # Perlu function untuk cek jam dari config lamp 
        $status = 0;
        // Contoh kasus
        // jam sekarang 9 malam
        // time_on = 7 Pagi
        // time_off = 8 Malam
        if (\Carbon\Carbon::now() >= $configLamp->time_on && \Carbon\Carbon::now() <= $configLamp->time_off){
            // lampu nyala
            $status = 1;
        } else {
            // lampu mati
            $status = 0;
        }
        return response()->json([
            "status" => "Success",
            "message" => "Config fetch successfuly",
            "data" => [
                "device" => $device,
                "heater" => $configHeater,
                "lamp" => [
                    "status" => $status
                ]
            ]
        ], 200);
    }
    
    // [POST] data from sensor
    public function post_data(Request $request, $deviceId)
    {
        try {
            $validated = $request->validate([
                'temperature' => ['decimal:1'],
                'humidity' => ['decimal:1'],
                'light_intensity' => ['decimal:1']
            ]);
            $dataSensor = DataSensor::create([
                'device_id' => $deviceId,
                'temperature' => $request->temperature,
                'humidity' => $request->humidity,
                'light_intensity' => $request->light_intensity,
            ]);
            MQTT::publish('/data', json_encode([
                'device_id' => $deviceId,
                'temperature' => $request->temperature,
                'humidity' => $request->humidity,
                'light_intensity' => $request->light_intensity,
                'created_at' => $dataSensor->created_at 
            ]));
            return response()->json([
                "status" => "Success",
                "message" => "Data successfuly created",
            ], 201);
        } catch (\Exception $e){
            return response()->json([
                "status" => "Error",
                "message" => "Data error",
                "error" => $e->getMessage(),
            ], 400);
        }
    }
}
