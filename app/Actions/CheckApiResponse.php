<?php

namespace App\Actions;

class CheckApiResponse
{
    public function macrokiosk($request)
    {
        if ($request == '400') {
            $msg = "Missing parameter or invalid field type";
        } elseif ($request == '401') {
            $msg = "Invalid username, password or ServID";
        } elseif ($request == '402') {
            $msg = "Invalid Account Type (when call using postpaid client’s account)";
        } elseif ($request == '403') {
            $msg = "Invalid Account, Your IP address is not allowed";
        } elseif ($request == '404') {
            $msg = "Invalid Account, Value for parameter “From” is too long";
        } elseif ($request == '405') {
            $msg = "Invalid Parameter, Value for parameter “Type” is not within the options";
        } elseif ($request == '406') {
            $msg = "Invalid Parameter, MSISDN given is either too long or too short";
        } elseif ($request == '408') {
            $msg = "System Error, Message Queue path retrieval failed";
        } elseif ($request == '409') {
            $msg = "System Error, Unable to send message";
        } elseif ($request == '411') {
            $msg = "Blacklisted, Recipient has Opted-Out from receive bulk promo message";
        } elseif ($request == '412') {
            $msg = "Invalid Account, Account suspended/terminated.";
        } elseif ($request == '413') {
            $msg = "Invalid Broadcast Time";
        } elseif ($request == '414') {
            $msg = "Invalid Account, nactive Account.";
        } elseif ($request == '415') {
            $msg = "Invalid Account, You not subscribe to Bulk SMS service";
        } elseif ($request == '416') {
            $msg = "Invalid Account, You not subscribe to this coverage";
        } elseif ($request == '417') {
            $msg = "Invalid Account, No route has been configured for this coverage";
        } elseif ($request == '418') {
            $msg = "Invalid Account, There is no available route for this broadcast";
        } elseif ($request == '419') {
            $msg = "Invalid Account, The Service ID is invalid";
        } elseif ($request == '420') {
            $msg = "System Error, System is unable to process the text message";
        } elseif ($request == '421') {
            $msg = "System Error, No coverage price has been set for this broadcast";
        } elseif ($request == '422') {
            $msg = "Invalid Account, No wallet.";
        } elseif ($request == '423') {
            $msg = "Invalid Account, Insufficient credit in wallet.";
        } elseif ($request == '424') {
            $msg = "Invalid Account, You not subscribe to this coverage";
        } elseif ($request == '425') {
            $msg = "System Error, No setting configuration for this route";
        } elseif ($request == '427') {
            $msg = "Invalid Broadcast Title";
        }elseif ($request == '429') {
            $msg = "Invalid Additional Parameter length / data type";
        }elseif ($request == '431') {
            $msg = "Invalid Account, Forbidden access JWT Authentication method is forbidden to authenticate MT";
        } elseif ($request == '500') {
            $msg = "System Error";
        }
        return $msg;
    }
}
