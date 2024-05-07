<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Operator;
use App\Models\Branch;
use App\Models\Collection;
use App\Models\Customer;
use App\Models\Req;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    //
    public function dashboard(){
        $branch = Auth::user()->branch;
    $today = Carbon::today();
    if($branch == '000'){
        $collection_today = Collection::where('created_at', '>=', $today)->pluck('amount')->sum();
        $collection_today_count = Collection::where('created_at', '>=', $today)->count();
        $collection_total = Collection::all()->pluck('amount')->sum();
        $collection_total_count = Collection::all()->count();
    }else{
        $collection_today = Collection::where('created_at', '>=', $today)->where('branch', $branch)->pluck('amount')->sum();
        $collection_branch_today = Collection::where('created_at', '>=', $today)->whereHas('customer', function ($query) use ($branch) {
            $query->where('branch', $branch);
        })->pluck('amount')->sum();
    $collection_today_count = Collection::where('created_at', '>=', $today)->where('branch', $branch)->count();
    $collection_branch_today_count = Collection::where('created_at', '>=', $today)->whereHas('customer', function ($query) use ($branch) {
        $query->where('branch', $branch);
    })->count();
    $collection_total = Collection::whereHas('customer', function ($query) use ($branch) {
        $query->where('branch', $branch);
    })->pluck('amount')->sum();
    $collection_total_count = Collection::whereHas('customer', function ($query) use ($branch) {
        $query->where('branch', $branch);
    })->count();
    }
    return view('backend.pages.dashboard', compact('collection_total', 'collection_today', 'collection_branch_today', 'collection_today_count', 'collection_branch_today_count', 'collection_total_count'));
    }
    public function allCollections(){
        // if(Auth::user() && Auth::user()->role == 'manager' && Auth::user()->branch == '000'){
        //     $collections = Collection::all();
        //     return view('backend.pages.all-collections', compact('collections'));
        // }
        // if(Auth::user() && Auth::user()->role == 'manager'){
        //     $manager = Auth::user()->id;
        //     // $branch = Auth::user()->branch;
        //     $customers = Customer::where('manager_id', $manager)->get();
        //     $collections = Collection::whereHas('customer', function ($query) use ($manager) {
        //         $query->where('branch', Auth::user()->branch);
        //     })->get();
        //     return view('backend.pages.all-collections', compact('collections'));
        // }else{
        //     return redirect()->back();
        // }
        if(Auth::user() && Auth::user()->role == 'manager' && Auth::user()->branch == '000'){
            $collections = Collection::all();
                return view('backend.pages.all-collections', compact('collections'));
        }elseif(Auth::user() && Auth::user()->role == 'manager'){
            $branch = Auth::user()->branch;
            $collections = Collection::whereHas('customer', function ($query) use ($branch) {
                $query->where('branch', $branch);
            })->orWhere('branch', $branch)
            ->get();
            return view('backend.pages.all-collections', compact('collections'));
        }else{
            return redirect()->back();
        }
    }
    public function generalReport(){
        if(Auth::user() && Auth::user()->role == 'manager' && Auth::user()->branch == '000'){
            $customers = Customer::all();
            return view('backend.pages.general-report', compact('customers'));
        }elseif(Auth::user() && Auth::user()->role == 'manager'){
            $manager = Auth::user()->id;
            $branch = Auth::user()->branch;
            $customers = Customer::where('branch', $branch)->get();
            return view('backend.pages.general-report', compact('customers'));
        }else{
            return redirect()->back();
        }
    }

    public function getUsers(){
        $branches = Branch::all();
        if(Auth::user() && Auth::user()->role == 'admin'){
            $users = User::all();
            return view('backend.pages.users', compact('users', 'branches'));
        }else{
            return redirect()->back();
        }
    }

    public function getCollections(Request $request){
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        
        if(Auth::user() && Auth::user()->role == 'manager' && Auth::user()->branch == '000'){
            $customer = Customer::where('id', $request->customer_id)->first();
            $collections = Collection::where('customer_id', $request->customer_id)
            ->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->get();
            return view('backend.pages.collection-date-specific', compact('customer', 'collections', 'start_date', 'end_date'));
        }elseif(Auth::user() && Auth::user()->role == 'manager'){
            $manager = Auth::user()->id;
            $branch = Auth::user()->branch;
            $customer = Customer::where('id', $request->customer_id)->where('branch', $branch)->first();
            $collections = Collection::where('customer_id', $request->customer_id)->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->whereHas('customer', function ($query) use ($manager) {
                $query->where('branch', Auth::user()->branch);
            })->get();
            return view('backend.pages.collection-date-specific', compact('customer', 'collections', 'start_date', 'end_date'));
        }else{
            return redirect()->back();
        }
    }
    public function allDateCollections(Request $request){
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        
        // if(Auth::user() && Auth::user()->role == 'manager' && Auth::user()->branch == '000'){
        //     $branch = Auth::user()->branch;
        //     $collections = Collection::whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->get();
        //     return view('backend.pages.all-collection-date', compact('collections', 'start_date', 'end_date'));
        // }elseif(Auth::user() && Auth::user()->role == 'manager'){
        //     $branch = Auth::user()->branch;
        //     $collections = Collection::whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->whereHas('customer', function ($query) use ($branch) {
        //         $query->where('branch', $branch);
        //     })->get();
        //     return view('backend.pages.all-collection-date', compact('collections', 'start_date', 'end_date'));
        // }else{
        //     return redirect()->back();
        // }
        if(Auth::user() && Auth::user()->role == 'manager' && Auth::user()->branch == '000'){
            $collections = Collection::whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->get();
            return view('backend.pages.all-collection-date', compact('collections', 'start_date', 'end_date'));
        }elseif(Auth::user() && Auth::user()->role == 'manager'){
            $branch = Auth::user()->branch;
            $collections = Collection::where(function ($query) use ($branch) {
                $query->whereHas('customer', function ($query) use ($branch) {
                $query->where('branch', $branch);
            })->orWhere('branch', $branch);
        })
            
            ->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->get();
            return view('backend.pages.all-collection-date', compact('collections', 'start_date', 'end_date'));
        }else{
            return redirect()->back();
        }
    }

    // public function reportDate(){
    //     if(Auth::user()){
    //         $customers = Customer::all();
    //         return view('backend.pages.report-date-specific', compact('customers'));
    //     }else{
    //         return redirect()->back();
    //     }
    // }

    public function customers(){
        if((Auth::user() && Auth::user()->role == 'manager' && Auth::user()->branch == '000') ){
            $customers = Customer::all();
            return view('backend.pages.customers', compact('customers'));
        }elseif(Auth::user() && Auth::user()->role === 'manager' || Auth::user()->role === 'operator'){
            $user = Auth::user()->id;
            $branch = Auth::user()->branch;
            $customers = Customer::where('branch', $branch)->get();
            return view('backend.pages.customers', compact('customers'));
        }elseif(Auth::user() && Auth::user()->role === 'collector'){
            $user = Auth::user()->id;
            $branch = Auth::user()->branch;
            $customers = Customer::all();
            return view('backend.pages.customers', compact('customers'));
        }
        else{
            return redirect()->back();
        }
    }

    public function customerRequest(){
        if(Auth::user() && Auth::user()->role == 'operator'){
            $user = Auth::user()->id;
            $requests = Req::where('operator_id', $user)->get();
            return view('backend.pages.requests', compact('requests'));
        }elseif(Auth::user() && Auth::user()->role == 'manager'){
            // $requests = Collection::whereHas('customer', function ($query) use ($manager) {
            //     $query->where('manager_id', $manager);
            // })->get();
            $branch = Auth::user()->branch;
            $operators = User::where('branch', $branch)->where('role', 'operator')->get();
            // $requests = Req::where();
            return view('backend.pages.requests', compact('operators'));
        }
        else{
            return redirect()->back();
        }
    }

    public function customerCollections($id){
        if(Auth::user() && Auth::user()->role == 'manager' && Auth::user()->branch == '000'){
            $customer = Customer::where('id', $id)->first();
            return view('backend.pages.collections', compact( 'customer'));
        }elseif(Auth::user() && Auth::user()->role == 'manager'){
            $manager = Auth::user()->id;
            $branch = Auth::user()->branch;
            $customer = Customer::where('id', $id)->where('branch',$branch)->first();
            if($customer){
                return view('backend.pages.collections', compact('customer'));
            }else{
                return redirect()->back();
            }
        }elseif(Auth::user() && Auth::user()->role == 'manager' && Auth::user()->branch == '000'){
            $customer = Customer::where('id', $id)->first();
            return view('backend.pages.collections', compact( 'customer'));
        }elseif(Auth::user() && Auth::user()->role == 'collector'){
            $collections = Collection::where('customer_id', $id)->get();
            $customer = Customer::where('id', $id)->first();
            return view('backend.pages.collections', compact( 'customer'));

        }else{
            return redirect()->back();
        }
    }

    public function changePassword(){
        return view('auth.password-change');
    }
}
