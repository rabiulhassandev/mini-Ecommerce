<?php

namespace App\Jobs;

use App\Sms\SMS;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SmsOneToOne implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /***
     *
     *
     * one to one relationship static method
     *
     *
     * calling syntax
     *
    -------------------------------------------------
     $contacts"= ['88017xxxxxxxx',+'88018xxxxxxxx'];
     $msg = "this is a demo message";
     -------------------------------------------------
     *
     *
     */
    public $number;
    public $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($number, $message)
    {
        $this->number = $number;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            return  SMS::OneToOne($this->number, $this->message)->send();
        } catch (\Throwable $th) {
            // $th->getCode()
            return \abort(403, $th->getMessage());
        }
    }
}
