<?php

namespace App\Http\Controllers\City;

use App\Http\Models\City;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use \Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Exception;
use Repo\Contracts\CityInterface;

class CityController extends Controller
{
    private $city;

    public function __construct(CityInterface $city)
    {
        $this->city = $city;
    }

    public function index()
    {
        $city = $this->city->index();

        return view('city.index')->with('city', $city);
    }

    public function addCity($id = null)
    {
        if (!$id == null) {
            $city = $this->city->index($id);

            return view('city.add_city')->with('city', $city);
        } else {
            return view('city.add_city');
        }
    }

    public function saveCity($id = null, Request $request)
    {

        $validationRules = [
            'city_name' => 'required'
        ];
        if (!isset($id)) {

            $validationRules['city_name'] = 'required|unique:' . City::TABLE . ',city_name';
        }

        $this->validate($request, $validationRules);

        $cityStatus = $this->city->saveCity($id, $request);

        $city = $cityStatus['result'];

        if ($cityStatus['status']['code'] == 200) {
            flash()->success($cityStatus['status']['message']);
            return Redirect::to('secure/city')->with('city', $city);

        } elseif ($cityStatus['status']['code'] == 422) {
            flash()->error($cityStatus['status']['message']);
        }

    }

    public function searchByCityName(Request $request)
    {
        $data = $request->all();

        $keyword['city_name'] = $request->get('keyword');

        $city = $this->city->index($keyword);

        return \response()->json($city);
    }

}