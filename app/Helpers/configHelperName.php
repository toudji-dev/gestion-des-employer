<?php

namespace App\Helpers;

use App\Models\Configuration;

class ConfigHelperName
{

    public static function NameDev()
    {

        $namedev = Configuration::where('type', 'DEVELOPPER_NAME')->value('value');
        return $namedev;
    }
}