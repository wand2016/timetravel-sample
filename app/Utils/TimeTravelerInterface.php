<?php

declare(strict_types=1);

namespace App\Utils;

use Carbon\Carbon;

/**
 * should be injected to Controller Action
 */
interface TimeTravelerInterface
{
    /**
     * @param Carbon|null $testNow=null
     * @return void
     */
    public function travel(?Carbon $testNow = null): void;
}
