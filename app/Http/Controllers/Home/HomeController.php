<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    private $ledger;

    public function __construct()
    {
    }

    public function index()
    {


        return view('home.index');
    }


    public function acknowledge(Request $request)
    {
        return response()->json([
            'status' => 'SUCCESS',
            'user' => $request->user
        ]);
    }

    public function acknowledge2(Request $request)
    {
        return response()->json([
            'status' => 'SUCCESS',
            'user' => $request->user
        ]);
    }
}
