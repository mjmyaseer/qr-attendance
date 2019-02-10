<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 2/10/2019
 * Time: 2:31 PM
 */

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Repo\Contracts\EventInterface;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{
    /**
     * @var EventInterface
     */
    private $event;

    /**
     * EventController constructor.
     * @param EventInterface $event
     */
    public function __construct(EventInterface $event)
    {

        $this->event = $event;
    }

    public function index()
    {
//        $id = 1;
//        $ids = "user_id = ".$id.",unique_id = ".$uid.",event_id = ".$eid;

//        dd(base64_encode(QrCode::format('png')->size(100)->generate($ids)));
        $event = $this->event->index();
        return view('event.index')->with('event', $event);
    }

    public function addEvent($id = null)
    {
        if (!$id == null) {
            $events = $this->event->index($id);

            return view('event.add_event')->with('event', $events);
        } else {
            return view('event.add_event');
        }

    }

    public function saveEvent($id = null, Request $request)
    {
        $validationRules = [
//            'customer_code' => 'required',
//            'customer_name' => 'required',
//            'customer_email' => 'required',
//            'customer_telephone' => 'required',
//            'customer_address' => 'required',
//            'customer_nic' => 'required'
        ];
        if (!isset($id)) {

//            $validationRules['customer_code'] = 'required|unique:' . Customer::TABLE . ',customer_code';
        }
        $this->validate($request, $validationRules);

        $eventStatus = $this->event->saveEvent($id, $request);
        $event = $eventStatus['result'];

        if ($eventStatus['status']['code'] == 200) {
            flash()->success($eventStatus['status']['message']);
            return Redirect::to('secure/event')->with('event', $event);

        } elseif ($eventStatus['status']['code'] == 422) {
            flash()->error($eventStatus['status']['message']);
        }

    }
}