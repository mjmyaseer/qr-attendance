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
use Repo\Contracts\CustomerInterface;
use Repo\Contracts\EventInterface;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{
    /**
     * @var EventInterface
     */
    private $event;
    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * EventController constructor.
     * @param EventInterface $event
     * @param CustomerInterface $customer
     */
    public function __construct(
        EventInterface $event,
        CustomerInterface $customer)
    {

        $this->event = $event;
        $this->customer = $customer;
    }

    public function index()
    {
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

    public function userEventIndex()
    {
        $event = $this->event->userEventIndex();
        return view('userEvent.index')->with('event', $event);
    }

    public function adduserEvent($id = null)
    {
        if (!$id == null) {
            $event = $this->event->userEventIndex($id);

            return view('userEvent.add_userEvent')->with('userEvent', $event);
        } else {

            $event = $this->event->index();
            $customers = $this->customer->index();
            $data = array(
                'userEvent' => $event,
                'customers' => $customers
            );
            return view('userEvent.add_userEvent')->with($data);
        }

    }

    public function saveUserEvent($id = null, Request $request)
    {
        $validationRules = [
//            'customer_code' => 'required',
        ];

        if (!isset($id)) {

//            $validationRules['customer_code'] = 'required|unique:' . Customer::TABLE . ',customer_code';
        }
        $this->validate($request, $validationRules);

        $eventStatus = $this->event->saveUserEvent($id, $request);
        $event = $eventStatus['result'];

        if ($eventStatus['status']['code'] == 200) {
            flash()->success($eventStatus['status']['message']);
            return Redirect::to('secure/event')->with('event', $event);

        } elseif ($eventStatus['status']['code'] == 422) {
            flash()->error($eventStatus['status']['message']);
        }
    }

    public function searchEventByName(Request $request)
    {
        $data = $request->all();

        $keyword['name'] = $request->get('keyword');

        $customer = $this->event->userEventIndex($keyword);

        return \response()->json($customer);
    }

    public function sendQR(Request $request)
    {
        $validationRules = [
            'user_id' => 'required',
        ];
        $this->validate($request, $validationRules);
        $user_id = $request->get('user_id');

        $results = $this->event->getQRDetails($user_id);

        return \response()->json($results);
    }
}