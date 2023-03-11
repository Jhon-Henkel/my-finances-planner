<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletModel extends Model
{
    protected $table = 'wallets';
    protected $fillable = array('id', 'name', 'type', 'amount');
    protected $casts = array('created_at' => 'datetime:Y-m-d H:m:s', 'updated_at' => 'datetime:Y-m-d H:m:s');
    protected $hidden = array();
    public $timestamps = false;

    public function movement()
    {
        return $this->hasMany('App\Models\MovementModel');
    }
}