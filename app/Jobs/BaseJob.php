<?php

declare(strict_types=1);

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Throwable;

abstract class BaseJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    /**
     * @var int The total time the job can run for before
     *          being stopped in seconds.
     */
    public $timeout = self::TWO_MINUTES;

    /**
     * @var int The total number of attempts.
     */
    public $tries = 3;

    protected const MINUTE = Carbon::SECONDS_PER_MINUTE;
    protected const TWO_MINUTES = self::MINUTE * 2;
    protected const FIVE_MINUTES = self::MINUTE * 5;
    protected const FIFTEEN_MINUTES = self::MINUTE * 15;

    /**
     * Additional steps to take when the job has failed
     *
     * @param Throwable|null $exception
     * @return void
     */
    public function failed(?Throwable $exception = null): void
    {
    }
}
