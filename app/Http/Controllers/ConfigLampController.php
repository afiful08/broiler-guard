<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\ConfigLamp;
use Illuminate\Support\Facades\Auth;

class ConfigLampController extends Controller
{
    public function index()
    {
        $devices = Device::where('user_id', Auth::user()->id)->get();
        
        if ($devices->isEmpty()) {
            return view('content.config.lamp.index', compact('devices'))->withErrors(['No devices found for the user.']);
        }
    
        $device_id = session('device_id') ?? $devices->first()->id;
        $config = ConfigLamp::where('device_id', $device_id)->first();
        
        return view('content.config.lamp.index', compact('devices', 'config'));
    }   

    public function show(Request $request)
    {   
        try {
            $validated = $request->validate([
                "device_id" => ["required"],
            ]);
    
            $config = ConfigLamp::where('device_id', $request->device_id)->first();

            // Check if config is null before returning the response
            if ($config === null) {
                return response()->json(['error' => 'Configuration not found'], 404);
            }
            
            return response()->json($config, 200);
        } catch (\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(Request $request)
    {
        try{
            $validated = $request->validate([
                "device_id" => ["required"],
                "time_on" => ['nullable','date_format:H:i'],
                "time_off" => ['nullable','date_format:H:i']
            ]);
    
            $config = ConfigLamp::where('device_id', $request->device_id)->first();

            // Check if config is null before accessing its properties
            if ($config === null) {
                return redirect()->back()->withErrors(['Configuration not found for the specified device.']);
            }

            $config->time_on = $request->time_on;
            $config->time_off = $request->time_off;
            $config->save();
    
            toastr()->success("Configuration updated successfully");
            return redirect()->back()->with('device_id', $request->device_id);
        } catch (\Exception $e){
            dd($e->getMessage());
        }
    }
}
