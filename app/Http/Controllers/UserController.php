<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use \Spatie\Permission\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        // Add alert on delete button
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('content.manage.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('content.manage.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                "name" => ['required'],
                "email" => ['required','email'],
                "password" => ['required'],
                "avatar" => ['mimes:jpg,jpeg,png']
            ]);
            
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            
            // optional image
            if ($request->hasFile('avatar')){
                $fileName = \Carbon\Carbon::now()->timestamp . '_' . str_replace(' ','_',strtolower($request->name)) . '.jpg';
                $user->avatar = $request->file('avatar')->storeAs('avatar', $fileName, 'public');
            }
            $user->save();
            $user->assignRole($request->role);
            toastr()->success("User Created Successfully");
            return redirect()->route('manage.users.index');
        } catch (\Illuminate\Database\QueryException $e){
            // catch error if users has duplicate email
            toastr()->error($e->getMessage());
            return redirect()->route('manage.users.create');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = Role::all();
        $user = User::find($id);
        return view('content.manage.users.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $validated = $request->validate([
                "name" => ['required'],
                "email" => ['required','email'],
                "avatar" => ['mimes:jpg,jpeg,png']
            ]);
            
            $user = User::find($id);
            $user->name = $request->name ?? $user->name;
            $user->email = $request->email ?? $user->email;
            if ($request->has('password')){
                $user->password = Hash::make($request->password);
            }
            
            // optional image
            if ($request->hasFile('avatar')){
                // Delete old image
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)){
                    Storage::disk('public')->delete($user->avatar);
                }
                $fileName = \Carbon\Carbon::now()->timestamp . '_' . str_replace(' ','_',strtolower($request->name)) . '.jpg';
                $user->avatar = $request->file('avatar')->storeAs('avatar', $fileName, 'public');
            }
            $user->save();
            $user->assignRole($request->role);
            toastr()->success("User Updated Successfully");
            return redirect()->route('manage.users.index');
        } catch (\Illuminate\Database\QueryException $e){
            // catch error if users has duplicate email
            toastr()->error($e->getMessage());
            return redirect()->route('manage.users.edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        // Check is users has device
        if ($user->devices()->exists()){
            toastr()->error("User can't be deleted cause this user has device");
            return redirect()->back();
        }
        
        // delete avatar if file exist
        if (Storage::disk('public')->exists($user->avatar)){
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();
        toastr()->success("User deleted successfully");
        return redirect()->back();
    }
}
