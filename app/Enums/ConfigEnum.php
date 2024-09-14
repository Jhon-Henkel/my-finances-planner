<?php

namespace App\Enums;

enum ConfigEnum: string
{
    case MfpTokenKey = 'mfp-token';
    case MfpUserTokenKey = 'x-mfp-user-token';
    case XMfpUserTokenKey = 'HTTP_X_MFP_USER_TOKEN';
    case MustShowWelcomePage = 'must_show_welcome_page';
    case MarketPlannerValue = 'market_planner_value';
    case DevDotEnv = 'local';
}
