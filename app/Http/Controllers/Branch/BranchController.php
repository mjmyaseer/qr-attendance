<?php

namespace App\Http\Controllers\Branch;

//use App\Http\Models\Category;
use App\Http\Models\Branch;
use App\Http\Models\Category;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use \Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Exception;
use Repo\Contracts\BranchInterface;
use Repo\Contracts\CategoryInterface;

class BranchController extends Controller
{
    private $branch;

    public function __construct(BranchInterface $branch)
    {
        $this->branch = $branch;
    }

    public function index()
    {
        $branch = $this->branch->index();

        return view('branch.index')->with('branch', $branch);
    }

    public function addBranch($id = null)
    {
        if (!$id == null) {
            $branch = $this->branch->index($id);

            return view('branch.add_branch')->with('branch', $branch);
        } else {
            return view('branch.add_branch');
        }
    }

    public function saveBranch($id = null, Request $request)
    {

        $validationRules = [
            'branch_name' => 'required'
        ];
        if (!isset($id)) {

            $validationRules['branch_name'] = 'required|unique:' . Branch::TABLE . ',branch_name';
        }

        $this->validate($request, $validationRules);

        $branchStatus = $this->branch->saveBranch($id, $request);

        $branch = $branchStatus['result'];

        if ($branchStatus['status']['code'] == 200) {
            flash()->success($branchStatus['status']['message']);
            return Redirect::to('secure/branch')->with('branch', $branch);

        } elseif ($branchStatus['status']['code'] == 422) {
            flash()->error($branchStatus['status']['message']);
        }

    }

    public function searchByBranchName(Request $request)
    {
        $data = $request->all();

        $keyword['branch_name'] = $request->get('keyword');

        $branch = $this->branch->index($keyword);

        return \response()->json($branch);
    }

}