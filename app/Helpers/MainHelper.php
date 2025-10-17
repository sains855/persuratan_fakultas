<?php

namespace App\Helpers;

use App\Models\LandingPage;

class MainHelper
{
    public static function getLandingPage()
    {
        return LandingPage::first();
    }
}
