<?php

namespace App\Enums;

enum DateFormatEnum: string
{
    case ModelDefaultDateFormat = 'datetime:Y-m-d H:i:s';
    case DefaultBrDateFormat = 'd/m/Y H:i:s';
    case DefaultDbDateFormat = 'Y-m-d H:i:s';
    case UsaDateFormatWithoutTime = 'Y-m-d';
    case OnlyMonth = 'm';
    case OnlyDay = 'd';
    case OnlyCompleteYear = 'Y';
}
