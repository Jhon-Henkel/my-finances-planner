<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $wallet_limit
 * @property int $credit_card_limit
 *
 * @mixin Builder
 */
class Plan extends Model
{
    protected $table = 'plan';
    protected $fillable = [];
}
