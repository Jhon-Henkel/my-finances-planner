<?php

namespace App\Enums;

class ConfigEnum
{
    const MFP_TOKEN = 'mfp-token';
    const MFP_USER_TOKEN = 'x-mfp-user-token';
    const X_MFP_USER_TOKEN = 'HTTP_X_MFP_USER_TOKEN';
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const MAX_WRONG_LOGIN_ATTEMPTS = 5;
}