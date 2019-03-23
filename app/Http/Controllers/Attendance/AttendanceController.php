<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 2/19/19
 * Time: 12:48 AM
 */

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Repo\Contracts\AttendanceInterface;

class AttendanceController extends Controller
{

    /**
     * @var AttendanceInterface
     */
    private $attendance;

    /**
     * AttendanceController constructor.
     * @param AttendanceInterface $attendance
     */
    public function __construct(AttendanceInterface $attendance)
    {

        $this->attendance = $attendance;
    }

    public function index()
    {
        $attendance = $this->attendance->index();

        return view('attendance.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByAttendance(Request $request)
    {
        $data = $request->all();
dd(22222);
        $keyword['customer_details'] = $request->get('keyword');

        $attendance = $this->attendance->index($keyword);

        return \response()->json($attendance);
    }

    public function attend(Request $request)
    {
        $validationRules = [
            'user_id' => 'required',
            'event_id' => 'required'
        ];

        $this->validate($request, $validationRules);

        $user = $request->get('user_id');
        $event = $request->get('event_id');

        $data['user_id'] = $user;
        $data['event_id'] = $event;

        $attend = $this->attendance->markAttend($data);

        if ($result['state']==1){
            return response()
                ->make('',204);
        }elseif ($result['state']==2){
            return response()
                ->make(Config::get('custom_messages.ERROR_WHILE_MARKING_ATTENDANCE'),403);
        }
    }

    public function markAttend(Request $request)
    {

        $attend = $this->attendance->markAttend($data);

        if ($result['state']==1){
            return response()
                ->make('',204);
        }elseif ($result['state']==2){
            return response()
                ->make(Config::get('custom_messages.ERROR_WHILE_MARKING_ATTENDANCE'),403);
        }
    }
}

