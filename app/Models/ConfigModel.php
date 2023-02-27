<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigModel extends Model
{
    protected $table = 'config';
    protected $fillable = array('id', 'name', 'value');
    protected $casts = array('created_at' => 'datetime:Y-m-d H:m:s', 'updated_at' => 'datetime:Y-m-d H:m:s');
    protected $hidden = array();
    public $timestamps = false;
}
