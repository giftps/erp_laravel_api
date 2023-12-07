<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Api\V1\Membership\Member;

use App\Notifications\BirthdayWishes;

class SendBirthdayWishes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:birthday_wish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->sendBirthdayWishes();
        return 0;
    }

    private function sendBirthdayWishes(){
        $members = Member::where('dob', 'LIKE', '%' . date('-m-d') . '%')->whereNotNull(['email', 'mobile_number'])->get();

        foreach($members as $member){
            $member->notify(new BirthdayWishes($member));
        }
    }
}
