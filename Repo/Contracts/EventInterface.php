<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 2/10/2019
 * Time: 2:52 PM
 */

namespace Repo\Contracts;


interface EventInterface
{
    public function index($id = null);

    public function getAllEvents();

    public function saveEvent($id = null, $request);

    public function saveUserEvent($id = null, $request);

    public function userEventIndex($id = null);

    public function getQRDetails($request);

    public function getEvent($request);

}