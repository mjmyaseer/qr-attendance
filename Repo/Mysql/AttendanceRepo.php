<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 2/19/19
 * Time: 12:53 AM
 */

namespace repo\Mysql;


use App\Http\Models\Attendance;
use App\Http\Models\Customer;
use App\Http\Models\Event;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Repo\Contracts\AttendanceInterface;

class AttendanceRepo implements AttendanceInterface
{
    /**
     * @var Attendance
     */
    private $attendance;

    /**
     * AttendanceRepo constructor.
     * @param Attendance $attendance
     */
    public function __construct(Attendance $attendance)
    {

        $this->attendance = $attendance;
    }

    public function index($id = null)
    {
        $query = DB::table(Attendance::TABLE)
            ->select(Attendance::TABLE . '.id as attendance_id',
                Attendance::TABLE . '.attended_date as attended_date',
                Customer::TABLE . '.customer_name as customer_name',
                Customer::TABLE . '.customer_nic as customer_nic',
                Customer::TABLE . '.customer_telephone as customer_telephone',
                Event::TABLE . '.event_name as event_name',
                Attendance::TABLE . '.created_at as supplier_created_at',
                Attendance::TABLE . '.updated_at as supplier_updated_at')
            ->leftJoin(Customer::TABLE, Attendance::TABLE . '.customer_id', '=', Customer::TABLE . '.id')
            ->leftJoin(Event::TABLE, Attendance::TABLE . '.event_id', '=', Event::TABLE . '.id');

        if (isset($id['customer_details']) && $id['customer_details'] != '') {

            $query->where(Customer::TABLE . '.customer_name', 'like', '%' . $id['customer_details'] . '%');
            $query->orwhere(Customer::TABLE . '.customer_nic', 'like', '%' . $id['customer_details'] . '%');
            $query->orwhere(Customer::TABLE . '.customer_email', 'like', '%' . $id['customer_details'] . '%');
            $query->orwhere(Customer::TABLE . '.customer_telephone', 'like', '%' . $id['customer_details'] . '%');

            $results = $query->orderBy(Attendance::TABLE . '.id', 'DESC')
                ->get();

            return $results;
        }

        $results = $query->get();

        return $results;
    }

    public function markAttend($data)
    {
        try {
            $attend = new Attendance();
            $attend->customer_id = $data['user_id'];
            $attend->event_id = $data['event_id'];
            $attend->attended_date = date("Y-m-d H:i:s");

            if ($attend->save()) {
                $attend['state'] = 1;

                return $attend;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return $attend['state'] = 2;
        }
    }
}