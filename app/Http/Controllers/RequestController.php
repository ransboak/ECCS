<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Req;
use App\Models\SttmAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    //
    public function addRequest(Request $request){
        if(Auth::user()->role == 'operator'){
            $request->validate([
                'cif' => 'required|string|size:9', 
            ]);

            $branch = Auth::user()->branch;
            $user = Auth::user()->id;
            $cif = $request->cif;
            //  return $customer = DB::connection('oracle')->table('sttm_cust_personal')->where('customer_no',$no)->select('first_name','middle_name','last_name','mobile_number','customer_no','e_mail')->first();
            // $corporate = DB::connection('oracle')->table('sttm_cust_corporate')->where('customer_no',$cif)->first();
            // $customer = SttmAccount::where('customer_no',$cif)->first();
            // $branch = Auth::user()->branch;
            $accountFirstThreeDigits = substr($request->cif, 0, 3);
    
            if ($accountFirstThreeDigits !== $branch) {
                return redirect()->back()->with('error', 'Unable to profile non branch customers');
            }

            $accounts = DB::connection('oracle')->table('sttm_cust_account')->where('cust_no',$cif)->where('ccy','=','GHS')->pluck('cust_ac_no')->toArray();
            $customer = DB::connection('oracle')->table('sttm_cust_personal')->where('customer_no',$cif)->first();
            // $corporate = DB::connection('oracle')->table('sttm_cust_corporate')->take(30)->get();
            $corporate = DB::connection('oracle')->table('sttm_cust_corporate')->where('customer_no',$cif)->first();
            $req_exist = Req::where('email', $customer->e_mail)->where('status', '!=', 'declined')->first();

            if(!$accounts){
                return redirect()->back()->with('error', 'User account does not exist');
            }
            
            $middle_name = $customer->middle_name;
            if(!$customer && !$corporate){
                return redirect()->back()->with('error', 'Customer not found');
            }
            if($corporate->corporate_name == null){
                if($req_exist){
                    return redirect()->back()->with('error', 'Customer request already submitted.');
                }
                if(!$middle_name){
                    $name = $customer->first_name . " " . $customer->last_name;
                }else{
                    $name = $customer->first_name . " " . $middle_name . " " . $customer->last_name;
                }
                $email = $customer->e_mail;
                $contact = $customer->mobile_number;
            }elseif($corporate && $customer){
                if($req_exist){
                    return redirect()->back()->with('error', 'Customer request already submitted.');
                }
                $name = $corporate->corporate_name;

                $new_email = $customer->e_mail;
                $split_emails = explode(" ", $new_email);
                $email = $split_emails[0];
                
                $new_number  = $customer->mobile_number;
                $split_numbers = explode(" ", $new_number);
                $contact = $split_numbers[0];
            }

            if(!$email){
                return  redirect()->route('customerRequest')->with('error', "Customer email not found");
            }
            if(!$contact){
                return  redirect()->route('customerRequest')->with('error', "Customer contact not found");
            }

            $req = Req::create([
                'name' => $name,
                'email' => $email,
                'contact' => $contact,
                'operator_id'=> Auth::user()->id,
            ]);


            if($req){
                return  redirect()->route('customerRequest')->with('success', "Request added successfully.");
            }else{
                return redirect()->route('customerRequest')->with('error', "Unable to add Request.");
                // return redirect()->back()->with('error', 'Unable to add Request.');
            }
        }else{
            return redirect()->route('customerRequest');
        }

    }


    public function confirmRequest(Request $request){
        // return view('backend.pages.confirm-customer');
        if(Auth::user()->role == 'operator'){
            $request->validate([
                'cif' => 'required|string|size:9', 
            ],[
                'cif.required' => "Please enter cif"
            ]);
    
            $branch = Auth::user()->branch;
            $user = Auth::user()->id;
            $cif = $request->cif;

            $accountFirstThreeDigits = substr($request->cif, 0, 3);
    
            if ($accountFirstThreeDigits !== $branch) {
                return redirect()->back()->with('error', 'Unable to profile non branch customers');
            }

            $accounts = DB::connection('oracle')->table('sttm_cust_account')->where('cust_no',$cif)->where('ccy','=','GHS')->pluck('cust_ac_no')->toArray();

            $customer = DB::connection('oracle')->table('sttm_cust_personal')->where('customer_no',$cif)->first();
            // $corporate = DB::connection('oracle')->table('sttm_cust_corporate')->take(30)->get();
            $corporate = DB::connection('oracle')->table('sttm_cust_corporate')->where('customer_no',$cif)->first();

            if(!$accounts){
                return redirect()->back()->with('error', 'User account does not exist');
            }

            $req_exist = Req::where('email', $customer->e_mail)->where('status', '!=', 'declined')->first();

            $middle_name = $customer->middle_name;

            if(!$customer && !$corporate){
                return redirect()->back()->with('error', 'Customer not found');
            }

            if($corporate->corporate_name == null)
            {
                if($req_exist)
                {
                    return redirect()->back()->with('error', 'Customer request already submitted.');
                }
                if(!$middle_name)
                {
                    $name = $customer->first_name . " " . $customer->last_name;
                }
                else
                {
                    $name = $customer->first_name . " " . $middle_name . " " . $customer->last_name;
                }
                
                $email = $customer->e_mail;
                $contact = $customer->mobile_number;
            }

            elseif($corporate && $customer)
            {
                if($req_exist)
                {
                    return redirect()->back()->with('error', 'Customer request already submitted.');
                }
                $name = $corporate->corporate_name;

                $new_email = $customer->e_mail;
                $split_emails = explode(" ", $new_email);
                $email = $split_emails[0];

                $new_number  = $customer->mobile_number;
                $split_numbers = explode(" ", $new_number);
                $contact = $split_numbers[0];
            }
           
            return view('backend.pages.confirm-customer', compact('name', 'email', 'contact', 'cif'));
           
        }
        else
        {
            return redirect()->back();
        }
    }

}
