<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 2/10/2019
 * Time: 2:55 PM
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    const DE_ACTIVE = 0;
    const ACTIVE    = 1;
    protected $table = "events";
    const TABLE = 'events';

}