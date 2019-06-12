<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SendNotification;
use Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $emails;
    protected $content;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emails, $content)
    {
        $this->emails = $emails;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $emails = $this->emails;
            $mailer = new SendNotification($this->content);
            foreach($emails as $email){
                Mail::to($email)->send($mailer);
            }       
        } catch (\Exception $e) {
            
        }
    }
}
