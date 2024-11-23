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
    protected $fillable = ['type', 'insight'];
    protected $hidden = ['id'];
    protected $casts = [
        'created_at' => DateFormatEnum::ModelDefaultDateFormat->value,
        'updated_at' => DateFormatEnum::ModelDefaultDateFormat->value
    ];
}
