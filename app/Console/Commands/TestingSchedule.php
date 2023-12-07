<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactSupport;

class TestingSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is testing if scheduling is working';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Mail::to('sokoenock@gmail.com')->send(new ContactSupport('Schedule Test', 'Hey, just testing the schedule'));

        return 0;
    }
}
