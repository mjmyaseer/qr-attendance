<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 2/5/2019
 * Time: 10:53 PM
 */

namespace Repo\Contracts;


interface OTPInterface
{
    public function saveOTP($data);

    public function verifyOTP($request);
}