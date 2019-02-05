<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 1/19/2019
 * Time: 6:22 PM
 */

namespace Repo\Contracts;

interface CityInterface
{
    public function index($keyword = null);

    public function saveCity($id = null,$request);
}