<?php

declare(strict_types=1);

namespace App\Utils;

use Carbon\Carbon;

class TimeTravelerNull implements TimeTravelerInterface
{
    /**
     * {@inheritDoc}
     */
    public function travel(?Carbon $testNow = null): void
    { }
}
