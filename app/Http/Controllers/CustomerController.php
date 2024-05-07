<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Req;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function approveRequest($id){
       

        $req = Req::find($id);
        $cust_exist = Customer::where('email', $req->email)->first();
        if($cust_exist){
            return redirect()->back()->with('error', 'Customer Already Exists');
        }
        $customer = Customer::create([
            'name' => $req->name,
            'email' => $req->email,
            'contact' => $req->contact,
            'manager_id'=> Auth::user()->id,
            'branch' => Auth::user()->branch
        ]);
        
        if($customer){
            $req->update(['status' => 'approved']);
        }
        // $req->update(['status' => "approved"]);

        if($customer){
            return redirect()->back()->with('success', "$customer->name added successfully.");
        }else{
            return redirect()->back()->with('error', 'Unable to add customer.');
        }
    }
    public function declineRequest($id){
        $req = Req::find($id);

        $requ = $req->update(['status' => 'declined']);
        // $req->update(['status' => "approved"]);

        if($requ){
            return redirect()->back()->with('success', "Request declined");
        }else{
            return redirect()->back()->with('error', 'Unable to add customer.');
        }
    }
}
