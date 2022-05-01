<?php

namespace App\Console\Commands;

use App\Jobs\ResetVotesJob;
use Illuminate\Console\Command;

class ResetVotes extends Command
{

    protected $signature = 'votes:reset';

    protected $description = 'This command resets all votes on posts daily';

    public function handle(): int
    {
        ResetVotesJob::dispatch();

        return self::SUCCESS;
    }
}
