<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 2/10/2019
 * Time: 2:52 PM
 */

namespace repo\Mysql;

use App\Http\Models\Customer;
use App\Http\Models\Event;
use App\Http\Models\User;
use App\Http\Models\UserEvent;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Repo\Contracts\EventInterface;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventRepo implements EventInterface
{
    protected $event;
    private $userEvent;

    public function __construct(
        Event $event,
        UserEvent $userEvent
    )
    {
        $this->event = $event;
        $this->userEvent = $userEvent;
    }

    public function index($id = null)
    {
//        print_r($id['event_id']);
//        print_r($id['user_id']);
//        dd($id);

        $query = DB::table(UserEvent::TABLE)
            ->select(
                Event::TABLE . '.id as event_id',
                Event::TABLE . '.event_name',
                Event::TABLE . '.qr_code as event_code',
                Event::TABLE . '.unique_id as event_uid',
                Event::TABLE . '.date as event_date',
                Event::TABLE . '.created_by as event_created_by',
                Event::TABLE . '.created_at as event_created_at',
                Event::TABLE . '.updated_at as event_updated_at')
        ->leftjoin(Event::TABLE,UserEvent::TABLE . '.event_id','=',Event::TABLE.'.id')
        ->leftjoin(Customer::TABLE ,UserEvent::TABLE . '.customer_id','=',Customer::TABLE.'.id');
        if ($id != '' && !isset($id['event_id'])) {
            $query->where(Event::TABLE . '.id', '=', $id['event_id']);
        }

        if ($id != '' && isset($id['user_id'])) {
            $query->where(UserEvent::TABLE . '.customer_id', '=', $id['user_id']);
        }

        if (isset($id['event_name']) && $id['event_name'] != '') {

            $query->where(Event::TABLE . '.event_name', 'like', '%' . $id['event_name'] . '%');
            $query->orwhere(Event::TABLE . '.unique_id', 'like', '%' . $id['unique_id'] . '%');
            $query->orwhere(Event::TABLE . '.date', '=', $id['date']);

            $results = $query->orderBy(Event::TABLE . '.id', 'DESC')
                ->get();

            return $results;
        }

        $results = $query->get();
        return $results;
    }

    public function saveEvent($id = null, $request)
    {
        try {
            if ($id != null) {
                $event = $this->event->where('id', $id)->first();
            } else {
                $event = new Event();
            }

            $uid = strtoupper(bin2hex(openssl_random_pseudo_bytes(16)));

            $event->event_name = $request->event_name;
            $event->unique_id = $uid;
            $event->date = $request->event_date;
            $event->created_by = $request->session()->get('userID');

            if ($event->save()) {
                $event['status'] = [
                    'status' => 'SUCCESS',
                    'code' => 200,
                    'message' => Config::get('custom_messages.NEW_EVENT_ADDED')
                ];

                $event['result'] = Event::all();

                $update = $this->event->where('id', $event->id)->first();
                $ids = "event_id = " . $event->id . ",unique_id = " . $uid;
                $update->qr_code = base64_encode(QrCode::format('png')->size(100)->generate($ids));
                $update->save();
                return $event;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return $event['status'] = [
                'status' => 'FAILED',
                'code' => 422,
                'error' => Config::get('custom_messages.ERROR_WHILE_EVENT_ADDING'),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getEvent($id)
    {
        $query = DB::table(Event::TABLE)
            ->select(
                Event::TABLE . '.id as event_id',
                Event::TABLE . '.event_name',
                Event::TABLE . '.event_code'
            )
            ->where(Event::TABLE . '.id', '=', $id);

        $results = $query->get();

        return $results;
    }

    public function saveUserEvent($id = null, $request)
    {
        try {
            if ($id != null) {
                $event = $this->userEvent->where('id', $id)->first();
            } else {
                $event = new UserEvent();
            }

            $uid = strtoupper(bin2hex(openssl_random_pseudo_bytes(16)));
            $ids = "event_id = " . $request->event_id . ",user_id = " . $request->user_id . ",unique_id = " . $uid;
            $event->customer_id = $request->customer_id;
            $event->event_id = $request->event_id;
            $event->unique_id = $uid;
            $event->qr_code = base64_encode(QrCode::format('png')->size(100)->generate($ids));
            $event->created_by = $request->session()->get('userID');
            $event->created_date = date("Y-m-d");

            if ($event->save()) {
                $event['status'] = [
                    'status' => 'SUCCESS',
                    'code' => 200,
                    'message' => Config::get('custom_messages.NEW_EVENT_ADDED')
                ];

                $event['result'] = Event::all();
                return $event;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return $event['status'] = [
                'status' => 'FAILED',
                'code' => 422,
                'error' => Config::get('custom_messages.ERROR_WHILE_EVENT_ADDING'),
                'message' => $e->getMessage()
            ];
        }
    }

    public function userEventIndex($id = null)
    {

        $query = DB::table(UserEvent::TABLE)
            ->select(
                UserEvent::TABLE . '.id as user_event_id',
                UserEvent::TABLE . '.customer_id',
                UserEvent::TABLE . '.event_id',
                UserEvent::TABLE . '.qr_code as event_code',
                UserEvent::TABLE . '.unique_id as event_uid',
                Event::TABLE . '.event_name',
                Customer::TABLE . '.customer_name',
                UserEvent::TABLE . '.created_by as event_created_by',
                UserEvent::TABLE . '.created_at as event_created_at',
                UserEvent::TABLE . '.updated_at as event_updated_at')
            ->leftJoin(Customer::TABLE, UserEvent::TABLE . '.customer_id', '=', Customer::TABLE . '.id')
            ->leftJoin(Event::TABLE, UserEvent::TABLE . '.event_id', '=', Event::TABLE . '.id');
        if ($id != '' && !isset($id['event_id'])) {
            $query->where(UserEvent::TABLE . '.id', '=', $id);
        }

        if (isset($id['name']) && $id['name'] != '') {
            $query->where(Event::TABLE . '.event_name', 'like', '%' . $id['name'] . '%');
            $query->orwhere(Customer::TABLE . '.customer_name', 'like', '%' . $id['name'] . '%');
            $results = $query->orderBy(Event::TABLE . '.id', 'DESC')
                ->get();

            return $results;
        }

        $results = $query->get();

        return $results;
    }

    public function getQRDetails($data)
    {
        DB::enableQueryLog();

        $query = DB::table(UserEvent::TABLE)
            ->select(
                UserEvent::TABLE . '.id as user_event_id',
                UserEvent::TABLE . '.customer_id',
                UserEvent::TABLE . '.event_id',
                UserEvent::TABLE . '.qr_code as user_event_qr',
                UserEvent::TABLE . '.unique_id as event_uid',
                Event::TABLE . '.event_name',
                Event::TABLE . '.qr_code',
                Event::TABLE . '.date as event_date',
                Customer::TABLE . '.customer_name',
                UserEvent::TABLE . '.created_by as event_created_by',
                UserEvent::TABLE . '.created_at as event_created_at',
                UserEvent::TABLE . '.updated_at as event_updated_at')
            ->leftJoin(Customer::TABLE, UserEvent::TABLE . '.customer_id', '=', Customer::TABLE . '.id')
            ->leftJoin(Event::TABLE, UserEvent::TABLE . '.event_id', '=', Event::TABLE . '.id')
            ->where(UserEvent::TABLE . '.customer_id', '=', $data['user_id'])
            ->where(UserEvent::TABLE . '.event_id', '=', $data['event_id'])
            ->where(UserEvent::TABLE . '.unique_id', '=', $data['token']);
        $results = $query->get();
        dd(
            DB::getQueryLog()
        );
        return $results;
    }
}
