<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 1/30/2019
 * Time: 9:29 PM
 */

namespace App\Http\Controllers\QR;

use App\Http\Controllers\Controller;
use Repo\Contracts\CustomerInterface;
use Repo\Contracts\EventInterface;

class QRController extends Controller
{
    private $QR;
    /**
     * @var EventInterface
     */
    private $event;

    /**
     * QRController constructor.
     * @param EventInterface $event
     */
    public function __construct(
        EventInterface $event
    )
    {

        $this->event = $event;
    }

    public function printEvent($type, $id)
    {
        switch ($type) {
            case 'event':
                $result = $this->event->getEvent($id);
                if (isset($result[0]) && !empty($result[0])) {
                    $events = [
                        'qr' => $result[0]->qr_code,
                        'name' => $result[0]->event_name
                    ];
                    return view('print.index')->with('event', $events);

                }

                flash()->error('Invalid Event ID');
                $event = $this->event->index();
                return view('event.index')->with('event', $event);
                break;

            case 'userEvent':
                $ser = [
                    'userEvent_id' => $id
                ];

                $result = $this->event->userEventIndex($ser);
                if (isset($result[0]) && !empty($result[0])) {
                    $events = [
                        'qr' => $result[0]->event_code,
                        'name' => $result[0]->event_name
                    ];
                    return view('print.index')->with('event', $events);

                }

                $event = $this->event->userEventIndex();
                flash()->error('Invalid Event ID');
                return view('userEvent.index')->with('event', $event);
                break;
        }

    }
}