<?php

namespace App\Tools\Request;

use App\Enums\RouteEnum;

class RequestToolsReal
{
    public function inputGet(null|string $key = null): mixed
    {
        if (! $key) {
            return $_GET;
        }
        return $_GET[$key] ?? null;
    }

    public function isApplicationInDevelopMode(): bool
    {
        return config('app.env') != 'production';
    }

    public function getUserIp(): string|null
    {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($ipList[0]);
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function getUserAgent(): string|null
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? null;
    }

    public function mountUrl(RouteEnum $route, string $query): string
    {
        $route = route($route) . $query;
        if ($this->isApplicationInDevelopMode()) {
            return $route;
        }
        return str_replace('http://', 'https://', $route);
    }
}
