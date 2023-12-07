<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail; 
use App\Mail\LetterOfGuarantee;

class SendGOPJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $provider_email;
    private $gop_path;

    public function __construct($provider_email, $gop_path)
    {
        $this->provider_email = $provider_email;
        $this->gop_path = $gop_path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->provider_email)->send(new LetterOfGuarantee($this->gop_path));
    }
}
