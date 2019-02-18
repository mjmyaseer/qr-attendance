<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 2/19/19
 * Time: 12:53 AM
 */

namespace Repo\Contracts;


interface AttendanceInterface
{
    public function index($id = null);
    public function markAttend($data);
}