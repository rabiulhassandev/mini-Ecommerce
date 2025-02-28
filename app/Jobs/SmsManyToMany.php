<?php

namespace App\Jobs;

use App\Sms\SMS;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SmsManyToMany implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    /***
     *
     *
     * many to many relationship static method
     *
     *
     * calling syntax
     *
     ------------------------------------------------
        $messages = [
            [
                'to' => '01712345678',
                'message' => 'test1'
            ],
            [
                'to' => '01512345678',
                'message' => 'test2'
            ],
        ];
    --------------------------------------------------
     *
     *
     */
    public $messages;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($messages)
    {
        $this->messages = $messages;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            return  SMS::ManyToMany($this->messages)->send();
        } catch (\Throwable $th) {
            // $th->getCode()
            return \abort(403, $th->getMessage());
        }
    }
}
