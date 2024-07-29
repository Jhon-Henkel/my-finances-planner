<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $tenant_hash
 * @property string $database
 * @property string $username
 * @property string $password
 *
 * @mixin Builder
 */
class Tenant extends Model
{
    protected $table = 'tenants';

    protected $fillable = [
        'tenant_hash',
        'database',
        'username',
        'password',
    ];
}
