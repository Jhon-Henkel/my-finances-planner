<?php

namespace App\VO;

use App\DTO\ConfigurationDTO;

class ConfigurationsVO
{
    public string $name;
    public string $value;

    public static function make(ConfigurationDTO $config): self
    {
        $vo = new self();
        $vo->name = $config->getName();
        $vo->value = $config->getValue();
        return $vo;
    }
}
