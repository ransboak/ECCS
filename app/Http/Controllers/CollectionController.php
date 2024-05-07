<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Customer;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    //
    public function addCollection(Request $request)
    {


        $user_id = Auth::user()->id;
        $branch = Auth::user()->branch;
        $user = User::find($user_id)->first();
        $user_name = $user->name;
        $formatted_amount = number_format($request->amount, 2, '.', ',');
        $customer = Customer::where('id', $request->customer_id)->first();

        $request->validate([
            'station_name' => 'required',
            'customer_id' => 'required',
            'station_officer' => 'required',
            'amount' => 'required|gt:0|numeric',
        ]);

        if (Auth::user()) {
            $collection = Collection::create([
                'station_name' => $request->station_name,
                'station_officer' => $request->station_officer,
                'amount' => $request->amount,
                'user_id' => $user_id,
                'customer_id' => $request->customer_id,
                'branch' => $branch
            ]);

            $time = \Carbon\Carbon::parse($collection->created_at)->format('H:i');
            $date = \Carbon\Carbon::parse($collection->created_at)->format('jS F, Y');

            if ($collection) {
                (new NotificationController)->SMS_nalo($customer->contact, "Dear Customer,
This is to acknowledge receipt of your cash deposit received at $request->station_name paid by $request->station_officer for an amount of GHS$formatted_amount.
Your account will be credited when the cash is lodged at the bank.
Collection was made on $date at $time

Thank you
Truly dependable..........
");
                $email = $customer->email;

                (new NotificationController)->mail($email, $request->station_name, $request->station_officer, $formatted_amount, $date, $time);

                return redirect()->back()->with('success', 'Collection Recorded Successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to record collection');
            }
        } else {
            return redirect()->back();
        }
    }


    public function momolookup()
    {
    //     $client = new Client();
    //     $headers = 
    //         [  
    //         'Cookie' => 'XSRF-TOKEN=eyJpdiI6InNnMDFVSXJocFFxNFQ1eWY4bS9Mc1E9PSIsInZhbHVlIjoiTWRTMkhHWlFyMDNKYjNhdFFhcmV2RWlhY2c3aStyY3RPNFFlSmplWks3aFVGQkJYWTZXSTlMOTFlYTBRRitmRGh2NXhlSEU5T0VoVC9MOHhObEp1ZkNQU09DV3htZFpzV1R4N2xqTU04blg3a29nY0pSWUd0VWlkSmVBbTJHSWsiLCJtYWMiOiI2NjM3YjViM2I2NDdkMWI1MDJhZWU0ZTExYjBkZWNhMTRlYzkxNDNjZGRiZDY1M2EwYWM0MjQxN2U1NzExOTU3IiwidGFnIjoiIn0%3D; laravel_session=eyJpdiI6ImREZ2ZkaGZSOXJtdWlxKy9yMFczdUE9PSIsInZhbHVlIjoiTWJTOXk1UCtBTGI4ekRLTDVIUEZRTUFBS0FnSkhNTXQ4dU9FSVBoQXlkb09FdEdwbEJ1ZHpkVzBveFRMMlg4UHJ5Zlp1MGFRakNQY3BMQ1Q0YlBBZGRUdFpLQ2IwaHd4Tjg3WGdHcEprTkh5c2kwRW1NMEk2cFVBVEhLQ0U4UWwiLCJtYWMiOiIxYzg3NzA4OGM1MzA1MzZmNGJkMDlmODcwMTE5OTE1MzQ0M2NkYjQ1MTAzZjk2NmU2NmZkNTRlYjlmMTYwOGJhIiwidGFnIjoiIn0%3D'
    //         ];
    //     $endpoint = 'http://inthub/ecall_new/api/flex/lookup';
        
        
        
    //     $body = [
        
        
    //     ];
        
    //     $res =  $client->get("http://inthub/ecall_new/api/flex/lookup");
    //    return $data = json_decode($res->getBody(),true);


       $client = new Client();
       return $response = $client->get("http://inthub/ecall_new/api/flex/lookup");
    

    }
}
