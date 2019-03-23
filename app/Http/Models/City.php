<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 1/19/2019
 * Time: 6:15 PM
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "city";
    const TABLE = 'city';

    public function Branch()
    {
        $this->belongsTo('Branch');
    }
}