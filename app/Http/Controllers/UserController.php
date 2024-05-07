<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function addUser(Request $request){
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required']
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('12345678'),
            'role' => $request->role,
            'branch' => $request->branch
        ]);

        if($user){
            return redirect()->back()->with('success', "$user->name added successfully.");
        }else{
            return redirect()->back()->with('error', 'Unable to add user.');
        }
    }

    public function editUser(Request $request, $id){
        if(Auth::user()->role == 'admin'){
            $request->validate([
                'branch' => ['required', 'string']
            ]);
            $branch = $request->branch;

            $user = User::where('id', $id)->first();

            $user_update = $user->update(['branch' => $branch]);

            if($user_update){
                return redirect()->back()->with('success', 'User details updated successfully');
            }else{
                return redirect()->back()->with('error', 'Failed to update user details.');
            }
        }else{
            return redirect()->back()->with('error', 'You do not have permission to update user details.');
        }
        
    }
}
