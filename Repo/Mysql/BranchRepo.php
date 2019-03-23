<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 1/19/2019
 * Time: 6:20 PM
 */

namespace repo\Mysql;


use App\Http\Models\Branch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Repo\Contracts\BranchInterface;
use Illuminate\Support\Facades\Config;

class BranchRepo implements BranchInterface
{
    private $branch;
    protected $id = 1;
    protected $name = '';
    protected $created_at = 1;
    protected $updated_at = 1;

    public function __construct(Branch $branch)
    {
        $this->branch = $branch;
    }

    public function index($id = null)
    {
        $query = DB::table(Branch::TABLE)
            ->select(Branch::TABLE.'.id as branch_id',Branch::TABLE.'.branch_name as branch_name',
                Branch::TABLE.'.branch_address as branch_address',
                Branch::TABLE.'.branch_phone as branch_phone',
                Branch::TABLE.'.city_id as city_name',
                Branch::TABLE.'.created_by as created_by',
                Branch::TABLE.'.created_at as created_at',
                Branch::TABLE.'.updated_at as updated_at');
        if ($id != '' && !isset($id['branch_name'])) {
            $query->where(Branch::TABLE . '.id', '=', $id);
        }

        if (isset($id['branch_name']) && $id['branch_name'] != '') {

            $query->where(Branch::TABLE . '.branch_name', 'like', '%' . $id['branch_name'] . '%');

            $results = $query->orderBy(Branch::TABLE . '.id', 'DESC')
                ->get();

            return $results;
        }

        $results = $query->get();

        return $results;
    }

    public function saveBranch($id = null,$request)
    {
        try {
            if($id != null){
                $branch = $this->branch->where('id', $id)->first();
            }else{
                $branch = new Branch();
            }

            $branch->branch_name = $request->branch_name;
            $branch->branch_address = $request->branch_address;
            $branch->branch_phone = $request->branch_phone;
            $branch->city_id = 1;
            $branch->created_by = $request->session()->get('userID');

            if ($branch->save()) {
                $branch['status'] = [
                    'status' => 'SUCCESS',
                    'code' => 200,
                    'message' => Config::get('custom_messages.NEW_BRANCH_ADDED')
                ];

                $branch['result'] = Branch::all();;
                return $branch;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return $branch['status'] = [
                'status' => 'FAILED',
                'code' => 422,
                'error' => Config::get('custom_messages.ERROR_WHILE_BRANCH_ADDING'),
                'message' => $e->getMessage()
            ];
        }
    }

}