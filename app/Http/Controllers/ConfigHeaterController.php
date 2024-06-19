<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\ConfigHeater;
use Illuminate\Support\Facades\Auth;

class ConfigHeaterController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login'); // Or any other action when the user is not authenticated
        }

        $devices = Device::where('user_id', $user->id)->get();
        if ($devices->isEmpty()) {
            // Handle the case where the user has no devices
            return view('content.config.heater.index', ['devices' => $devices, 'config' => null]);
        }

        $device_id = session('device_id') ?? $devices->first()->id;
        $config = ConfigHeater::where('device_id', $device_id)->first();
        return view('content.config.heater.index', compact('devices', 'config'));
    }

    public function show(Request $request)
    {   
        try {
            $validated = $request->validate([
                "device_id" => ["required"],
            ]);
    
            $config = ConfigHeater::where('device_id', $request->device_id)->first();
            if (!$config) {
                return response()->json(['message' => 'Configuration not found'], 404);
            }
            return response()->json($config, 200);
        } catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                "device_id" => ["required"],
                "mode" => ["required", 'in:manual,automatic'],
                "status" => ['nullable', 'boolean'],
                "max_temp" => ['nullable', 'integer'],
                "min_temp" => ['nullable', 'integer']
            ]);
    
            $config = ConfigHeater::where('device_id', $request->device_id)->first();
            if (!$config) {
                toastr()->error("Configuration not found");
                return redirect()->back()->with('device_id', $request->device_id);
            }

            $config->mode = strtoupper($request->mode);
            if ($request->mode == "manual") {
                $config->status = $request->status;
            } else {
                $config->max_temp = $request->max_temp;
                $config->min_temp = $request->min_temp;
            }
            $config->save();
    
            toastr()->success("Configuration updated successfully");
            return redirect()->back()->with('device_id', $request->device_id);
        } catch (\Exception $e){
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }
}
