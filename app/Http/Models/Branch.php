<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 1/19/2019
 * Time: 6:15 PM
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = "branch";
    const TABLE = 'branch';

    public function City()
    {
        $this->belongsTo('City');
    }
}