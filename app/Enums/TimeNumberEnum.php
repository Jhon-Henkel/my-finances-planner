<?php

namespace App\Enums;

enum TimeNumberEnum: int
{
    case TwoHourInSeconds = 7200;
    case ThreeHourInSeconds = 10800;
    case OneDayInSeconds = 86400;
    case OneWeekInSeconds = 604800;
}
