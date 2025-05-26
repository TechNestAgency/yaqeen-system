<?php

namespace App\Http\Controllers\Admin\Billings;

use App\Http\Controllers\Controller;
use App\Models\Billings;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

class BillingsController extends Controller
{
    public function index($month)
    {
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $billings = \App\Models\Billings::where('is_paid', 0)
    ->where('month', $month)
    ->where('year', 2025)
            ->selectRaw('student_id, sum(amount) as total_amount')
            ->groupBy('student_id')
            ->get();
        return view('admin.bilings.index',compact('billings','month'));
    }

    public function pay($student_id,$month,$amount,$currency)
    {
        $amount = round($amount, 2);
        $student = \App\Models\User::find($student_id);
        return view('pay.index',compact('student','amount','month','currency'));
    }

    public function pay2($student_id,$month,$amount,$currency)
    {
        $amount = round($amount, 2);
        return view('pay.pay2',compact('amount','month','currency'));
    }

    public function showCredit($student_id,$amount,$month)
    {
        $user = User::find($student_id);
        $billing = Billings::where('student_id', $student_id)->whereMonth('created_at', $month)->where('is_paid',0)->first();


        if ($billing) {
            if (!$user) {
                abort(404);
            }

            $amount = floor($amount);
            $currency = "USD";
            if ( $user->currency =='EUR') {
                $currency = 'EUR';
            }
            if ( $user->currency =='GBP') {
                $currency = 'GBP';
            }
            if ( $user->currency =='NZD') {
                $amount = round($amount / 1.62 , 1);
                                $currency = 'USD';
            }
            if ( $user->currency =='CAD') {
                $amount = round($amount / 1.36 , 1);
                                $currency = 'USD';

            }


            $client = new Client(); //GuzzleHttp\Client
            $url = "https://community.xpay.app/api/v1/payments/pay/variable-amount";
            $name = $user->user_name.' '.$user->user_name;

            $faker = Faker::create();
            $name = $faker->name;

            $mobileNumber = $faker->e164PhoneNumber;


            $data = [
                "billing_data" => [
                    "name" =>$name,
                    "email" => substr(md5(mt_rand()), 0, 7).'@tarteel.com',
                    "phone_number" =>$mobileNumber
                ],
                "custom_fields" => [
                    [
                        "field_label" => "user_id",
                        "field_value" => $user->id
                    ],
                    [
                        "field_label" => "month",
                        "field_value" => $month
                    ],
                ],
                "amount" => $amount,
                "currency" => $currency,
                "variable_amount_id" => 170,
                "community_id" => "d31zy0w",
                "pay_using" => "card"
            ];


            $headers = [
                'x-api-key' => 'o9lg96dD.YDEmcX2ia8bGl5CpbPX3C794WnTl667R',
                'Content-Type' => 'application/json',
            ];


            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'body' => json_encode($data),
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            $bodyArray = json_decode($body, true);

            if ($statusCode == 200 && isset($bodyArray['data']['iframe_url'])) {
                return redirect($bodyArray['data']['iframe_url']);
            }

            return $body;
        }else{
            return view('success');
        }
    }

    public function showCreditCustom($currency,$amount,$month)
    {

            $amount = floor($amount);
            if ( $currency =='EUR') {
                $currency = 'EUR';
            }
                if ( $currency =="USD") {
                    $currency = "USD";
                }
            if ( $currency =='GBP') {
                $currency = 'GBP';
            }
          if ( $currency =='NZD') {
                $amount = round($amount / 1.62 , 1);
                                $currency = 'USD';
            }
            if ( $currency =='CAD') {
                $amount = round($amount / 1.36 , 1);
                                $currency = 'USD';

            }

            $client = new Client(); //GuzzleHttp\Client
            $url = "https://community.xpay.app/api/v1/payments/pay/variable-amount";

            $faker = Faker::create();
            $name = $faker->name;

            $mobileNumber = $faker->e164PhoneNumber;


            $data = [
                "billing_data" => [
                    "name" =>$name,
                    "email" => substr(md5(mt_rand()), 0, 7).'@tarteel.com',
                    "phone_number" =>$mobileNumber
                ],
                "custom_fields" => [
                    [
                        "field_label" => "user_id",
                        "field_value" => 0
                    ],
                    [
                        "field_label" => "month",
                        "field_value" => $month
                    ],
                ],
                "amount" => $amount,
                "currency" => $currency,
                "variable_amount_id" => 170,
                "community_id" => "d31zy0w",
                "pay_using" => "card"
            ];


            $headers = [
                'x-api-key' => 'o9lg96dD.YDEmcX2ia8bGl5CpbPX3C794WnTl667R',
                'Content-Type' => 'application/json',
            ];


            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'body' => json_encode($data),
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            $bodyArray = json_decode($body, true);

            if ($statusCode == 200 && isset($bodyArray['data']['iframe_url'])) {
                return redirect($bodyArray['data']['iframe_url']);
            }

            return $body;
    }

    public function handlePayment(Request $request)
    {
        $transactionId = $request->input('transaction_id');

        $client = new Client(); //GuzzleHttp\Client
        $url = "https://community.xpay.app/api/communities/d31zy0w/transactions/{$transactionId}";

        $headers = [
            'x-api-key' => 'o9lg96dD.YDEmcX2ia8bGl5CpbPX3C794WnTl667R',
            'Content-Type' => 'application/json',
        ];

        $response = $client->request('GET', $url, ['headers' => $headers]);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        if ($statusCode == 200) {
            $bodyArray = json_decode($body, true);

            if ($request->input('transaction_status') == 'SUCCESSFUL') {
                if ($request->input('user_id') == 0){
                    return view('pay.success');
                }
                $userId = $request->input('user_id');
                $month = $request->input('month');
                // Update the user's billing status in your database
                Billings::where('student_id', $userId)->whereMonth('created_at', $month)->update(['is_paid' => 1]);
                return view('pay.success');
            }
        }

        return response()->json(['message' => 'successful successful successful NA']);
    }

    public function success(Request $request,$month)
    {

        $userId = $request->input('student_id');

        Billings::where('student_id',$userId)->whereMonth('created_at',$month)->update(['is_paid'=>1]);
        return view('pay.success');
    }
    public function paidBillings($month)
    {
       $month = str_pad($month, 2, '0', STR_PAD_LEFT);
$billings = \App\Models\Billings::where('is_paid', 1)
    ->where('month', $month)
    
            ->selectRaw('student_id, sum(amount) as total_amount')
            ->groupBy('student_id')
            ->get();
        return view('admin.bilings.paid',compact('billings','month'));
    }

    public function salaries($month)
    {
        $salaries = \App\Models\Lessons::whereMonth('created_at',$month)
        ->whereYear('created_at',2025)
            ->selectRaw('teacher_id, sum(lesson_duration) as total_hours')
            ->groupBy('teacher_id')
            ->get();
        return view('admin.salaries.index',compact('salaries','month'));
    }

    public function salariesAmount($month,Request $request)
    {
        $salaries = \App\Models\Lessons::whereMonth('created_at',$month)
                ->whereYear('created_at',2025)
            ->selectRaw('teacher_id, sum(lesson_duration) as total_hours')
            ->groupBy('teacher_id')
            ->get();
        $amount = $request->input('amount');
        return view('admin.salaries.index',compact('salaries','month','amount'));
    }

}
