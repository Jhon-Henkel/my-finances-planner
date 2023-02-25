<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teste extends Model
{
    //Nome da tabela no db
    protected $table = 'teste';
    //colunas que podem ser alteradas no db
    protected $fillable = array('id', 'name');
    //podemos converter valores vindos do db, exemplo 'dateStart' => 'Timestamp'
    protected $casts = array();
    //colunas que seão ocultadas no retorno json
    protected $hidden = array();
    //criar automaticamente campos updated_at, created_at e deleted_at, quando não se tem isso no db, marcar como false
    public $timestamps = false;
}
