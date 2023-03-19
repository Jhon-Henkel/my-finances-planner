<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovementModel extends Model
{
    protected $table = 'movements';
    protected $fillable = array('id', 'wallet_id', 'description', 'type', 'amount');
    protected $casts = array('created_at' => 'datetime:Y-m-d H:m:s', 'updated_at' => 'datetime:Y-m-d H:m:s');
    protected $hidden = array();
    public $timestamps = false;
}