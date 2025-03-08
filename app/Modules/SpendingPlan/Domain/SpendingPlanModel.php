<?php

namespace App\Modules\SpendingPlan\Domain;

use App\Enums\DateFormatEnum;
use App\Models\WalletModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $wallet_id
 * @property string $description
 * @property float $amount
 * @property int $installments
 * @property string $forecast
 * @property string $created_at
 * @property string $updated_at
 * @property string $bank_slip_code
 *
 *
 * @mixin Builder
 */
class SpendingPlanModel extends Model
{
    use HasFactory;

    protected $table = 'future_spent';
    protected $fillable = ['id', 'wallet_id', 'description', 'amount', 'forecast', 'installments'];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];

    public function wallet(): WalletModel
    {
        return $this->belongsTo(WalletModel::class, 'wallet_id', 'id')->first();
    }
}
