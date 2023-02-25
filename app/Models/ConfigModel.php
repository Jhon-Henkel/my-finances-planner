<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigModel extends Model
{
    protected $table = 'config';
    protected $fillable = array('id', 'name', 'value');
    protected $casts = array('created_at' => 'Timestamp', 'updated_at' => 'Timestamp');
    protected $hidden = array();
    public $timestamps = false;
}
