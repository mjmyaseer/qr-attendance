<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 2/5/2019
 * Time: 10:53 PM
 */

namespace repo\Mysql;


use App\Http\Models\OTP;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Repo\Contracts\OTPInterface;

class OTPRepo implements OTPInterface
{
    private $otp;

    public function __construct(OTP $otp)
    {
        $this->otp = $otp;
    }

    public function saveOTP($data)
    {
            $otp = new OTP();
            $otp->where('customer_id', '=', $data->customer_id)->delete();
            $otp->customer_id = $data->customer_id;
            $otp->otp = $data->otp;
            $otp->save();
            return $otp;
    }

}