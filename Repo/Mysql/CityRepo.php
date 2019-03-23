<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 1/19/2019
 * Time: 6:20 PM
 */

namespace repo\Mysql;


use App\Http\Models\Branch;
use App\Http\Models\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Repo\Contracts\BranchInterface;
use Illuminate\Support\Facades\Config;
use Repo\Contracts\CityInterface;

class CityRepo implements CityInterface
{
    private $city;
    protected $id = 1;
    protected $name = '';
    protected $created_at = 1;
    protected $updated_at = 1;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function index($id = null)
    {
        $query = DB::table(City::TABLE)
            ->select(City::TABLE.'.id as city_id',City::TABLE.'.city_name as city_name',
                City::TABLE.'.created_by as created_by',
                City::TABLE.'.created_at as created_at',
                City::TABLE.'.updated_at as updated_at');
        if ($id != '' && !isset($id['city_name'])) {
            $query->where(City::TABLE . '.id', '=', $id);
        }

        if (isset($id['city_name']) && $id['city_name'] != '') {

            $query->where(City::TABLE . '.city_name', 'like', '%' . $id['city_name'] . '%');

            $results = $query->orderBy(City::TABLE . '.id', 'DESC')
                ->get();

            return $results;
        }

        $results = $query->get();

        return $results;
    }

    public function saveCity($id = null,$request)
    {
        try {
            if($id != null){
                $city = $this->city->where('id', $id)->first();
            }else{
                $city = new City();
            }

            $city->city_name = $request->city_name;
            $city->created_by = $request->session()->get('userID');

            if ($city->save()) {
                $city['status'] = [
                    'status' => 'SUCCESS',
                    'code' => 200,
                    'message' => Config::get('custom_messages.NEW_CITY_ADDED')
                ];

                $city['result'] = City::all();;
                return $city;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return $city['status'] = [
                'status' => 'FAILED',
                'code' => 422,
                'error' => Config::get('custom_messages.ERROR_WHILE_CITY_ADDING'),
                'message' => $e->getMessage()
            ];
        }
    }

}