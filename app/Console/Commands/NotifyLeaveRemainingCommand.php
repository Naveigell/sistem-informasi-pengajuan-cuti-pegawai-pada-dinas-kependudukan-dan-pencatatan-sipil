<?php

namespace App\Console\Commands;

use App\Models\Leave;
use Illuminate\Console\Command;

class NotifyLeaveRemainingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify leaves remaining to all users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Leave::notifyLeaveRemainingToAllUsers();

        return Command::SUCCESS;
    }
}
