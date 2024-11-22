<?php

namespace App\Modules\AiInsights\Model;

use App\Enums\DateFormatEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */
class AiInsightModel extends Model
{
    protected $table = 'ai_insight';
    protected $fillable = ['id', 'type', 'insight'];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
}
