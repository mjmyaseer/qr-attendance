<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 1/30/2019
 * Time: 9:29 PM
 */
namespace App\Http\Controllers\QR;

use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QRCode;

class QRController extends Controller
{
    private $QR;

    public function __construct()
    {

    }

    public function scanQRCode()
    {
        return QrCode::size(500)->generate('Hi Hi Hi!!');
    }
}