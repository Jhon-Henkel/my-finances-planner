<?php

use src\API\Response;

abstract class RouteSwitch
{
    protected function start(): void
    {
        //my start route
    }

    public function __call($name, $arguments): void
    {
        Response::renderNotFound();
    }
}