<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\User;
use App\Models\ConfigHeater;
use App\Models\ConfigLamp;


class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices = Device::all();

        // Add alert on delete button
        $title = 'Delete device!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('content.manage.device.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::role('farmer')->get();
        return view('content.manage.device.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                "id" => ['required', 'max:6'],
                "user_id" => ['required'],
                "name" => ['required'],
            ]);
            
            // Add Device Data
            $device = new Device;
            $device->id = $request->id;
            $device->user_id = $request->user_id;
            $device->name = $request->name;   
            $device->save();

            // When add device auto create config heater
            $heater = new ConfigHeater;
            $heater->device_id = $request->id;
            $heater->save();

            // and auto create config lamp
            $lamp = new ConfigLamp;
            $lamp->device_id = $request->id;
            $lamp->save();

            toastr()->success("Device Created Successfully");
            return redirect()->route('manage.devices.index');
        } catch (\Illuminate\Database\QueryException $e){
            toastr()->error($e->getMessage());
            return redirect()->route('manage.devices.create');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $device = Device::find($id);
        $users = User::role('farmer')->get();
        return view('content.manage.device.edit', compact('device', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $validated = $request->validate([
                "id" => ['required', 'max:6'],
                "user_id" => ['required'],
                "name" => ['required'],
            ]);
            
            $device = Device::find($id);
            $device->id = $request->id ?? $device->id;
            $device->user_id = $request->user_id ?? $device->user_id;
            $device->name = $request->name ?? $device->name;   
            $device->save();

            toastr()->success("Device Updated Successfully");
            return redirect()->route('manage.devices.index');
        } catch (\Illuminate\Database\QueryException $e){
            toastr()->error($e->getMessage());
            return redirect()->route('manage.devices.edit',$id);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $device = Device::find($id);
        
        $heater = ConfigHeater::where('device_id',$id)->first();
        $lamp = ConfigLamp::where('device_id',$id)->first();

        $lamp->delete();
        $heater->delete();
        $device->delete();
        toastr()->success("Device deleted successfully");
        return redirect()->back();
    }
}
