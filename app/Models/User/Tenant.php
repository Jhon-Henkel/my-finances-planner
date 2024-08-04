<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

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

    protected array $encryptFields = [
        'username',
        'password',
        'database',
    ];

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptFields)) {
            $value = Crypt::encryptString($value);
        }
        return parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if (in_array($key, $this->encryptFields)) {
            $value = Crypt::decryptString($value);
        }
        return $value;
    }
}
