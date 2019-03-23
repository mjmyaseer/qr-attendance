<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 2/11/2019
 * Time: 12:04 AM
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    const DE_ACTIVE = 0;
    const ACTIVE    = 1;
    protected $table = "user_event_mapping";
    const TABLE = 'user_event_mapping';

}