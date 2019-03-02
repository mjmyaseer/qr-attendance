<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 1/30/2019
 * Time: 9:29 PM
 */
namespace App\Http\Controllers\QR;

use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{
    private $QR;

    public function __construct()
    {

    }

    public function scanQRCode()
    {
        $result = QrCode::size(500)->generate('Make me into a QrCode!');


//        return view('print.index')->with('result', $result);
    }
}