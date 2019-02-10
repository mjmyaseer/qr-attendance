<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 2/10/2019
 * Time: 2:52 PM
 */

namespace repo\Mysql;

use App\Http\Models\Event;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Repo\Contracts\EventInterface;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventRepo implements EventInterface
{
    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function index($id = null){
        $query = DB::table(Event::TABLE)
            ->select(
                Event::TABLE . '.id as event_id',
                Event::TABLE . '.event_name',
                Event::TABLE . '.qr_code as event_code',
                Event::TABLE . '.unique_id as event_uid',
                Event::TABLE . '.date as event_date',
                Event::TABLE . '.created_by as event_created_by',
                Event::TABLE . '.created_at as event_created_at',
                Event::TABLE . '.updated_at as event_updated_at');
        if ($id != '' && !isset($id['event_id'])) {
            $query->where(Event::TABLE . '.id', '=', $id);
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

            $uid = uniqid();
//
            $event->event_name = $request->event_name;
            $event->unique_id = $uid;
            $event->date = $request->event_date;
//            $event->qr_code = base64_encode(QrCode::format('png')->size(100)->generate($ids)
            $event->created_by = $request->session()->get('userID');

            if ($event->save()) {
                $event['status'] = [
                    'status' => 'SUCCESS',
                    'code' => 200,
                    'message' => Config::get('custom_messages.NEW_EVENT_ADDED')
                ];

                $event['result'] = Event::all();

                $update = $this->event->where('id', $event->id)->first();
                $ids = "event_id = ".$event->id.",unique_id = ".$uid;
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
}
