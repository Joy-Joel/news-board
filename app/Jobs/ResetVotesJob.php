<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ResetVotesJob extends BaseJob
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct()
    {
        //$this->onQueue('throttled-one');
    }

    public $timeout = self::TWO_MINUTES;

    public function handle(): void
    {
        DB::table('votes')
            ->truncate();
    }
}
