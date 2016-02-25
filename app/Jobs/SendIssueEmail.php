<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Subscribe;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendIssueEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $issue;
    protected $articles;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Subscribe $user, $issue, $articles)
    {

        $this->user = $user;
        $this->articles = $articles;
        $this->issue = $issue;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(\Mail $mail)
    {
        $user = $this->user;
        $issue = $this->issue;
        $articles = $this->articles;
        $mail::send('send', [
            'issue' => $issue,
            'articles' => $articles,
            'unsubscribe' => route('unsubscribe', ['confirm_code' => $user->confirm_code])
        ], function ($message) use ($user, $issue) {
            $message->to($user->email, '读者')->subject("Kratos第{$issue}期");
        });
    }

    /**
     * 处理失败任务, 方法名必须是 failed
     *
     */
    public function failed()
    {
        //
    }
}
