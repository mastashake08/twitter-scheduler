<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Twitter;
class ProcessTweet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tweet;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Tweet $tweet)
    {
        //
        $this->tweet = $tweet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //post the tweet
        Twitter::postTweet(['status' => $this->tweet->content, 'format' => 'json']);
        //delete the tweet from database
        \App\Tweet::destroy($this->tweet->id);
    }
}
