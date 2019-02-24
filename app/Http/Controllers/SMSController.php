<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 2/21/19
 * Time: 10:44 PM
 */

namespace App\Http\Controllers;

use GuzzleHttp\Client as GuzzleClient;

class SMSController extends Controller
{

    public function __construct()
    {

    }

    public function sendSMS($data)
    {
        $phone = $data['phone'];
        $message = $data['message'];

        $payload = [
            "source" => "SLJI",
            "destinations"=> ["+94".$phone.""],
            "content"=> [
                "sms"=>"".$message.""
            ],
            "transports"=>["sms"]
        ];

        $client = new GuzzleClient();

        $response = $client->post('https://api.getshoutout.com/coreservice/messages', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' =>'Apikey eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiI2NWMxYTczMC0yZjUwLTExZTktYjI2NS1lOWRiMTM0MWI2OTUiLCJzdWIiOiJTSE9VVE9VVF9BUElfVVNFUiIsImlhdCI6MTU1MDAzNTc5NiwiZXhwIjoxODY1NjU0OTk2LCJzY29wZXMiOnsiYWN0aXZpdGllcyI6WyJyZWFkIiwid3JpdGUiXSwibWVzc2FnZXMiOlsicmVhZCIsIndyaXRlIl0sImNvbnRhY3RzIjpbInJlYWQiLCJ3cml0ZSJdfSwic29fdXNlcl9pZCI6IjI3MDgiLCJzb191c2VyX3JvbGUiOiJ1c2VyIiwic29fcHJvZmlsZSI6ImFsbCIsInNvX3VzZXJfbmFtZSI6IiIsInNvX2FwaWtleSI6Im5vbmUifQ.hQlPbRlTMCaA9uOm9orwVmZR6GLTgNjIPTGqWrKrW-A'],
            'json'    => $payload
        ]);

    }
}