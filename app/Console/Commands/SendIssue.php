<?php

namespace App\Console\Commands;

use App\Models\Issue;
use App\Models\Category;
use App\Models\Subscribe;
use App\Jobs\SendIssueEmail;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SendIssue extends Command
{
    use DispatchesJobs; // 推送任务到队列的 trait
    /**
     * The name and signature of the console command.
     * 等下要使用 php artisan * 的名称，比如这边就是 php artisan sendIssue
     *
     * @var string
     */
    protected $signature = 'sendIssue';

    /**
     * The console command description.
     * 该任务的描述, 可以随意写
     *
     * @var string
     */
    protected $description = 'send issue to subscribe users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * 该任务具体的执行代码, 这边实现定时发邮件
     *
     * @return mixed
     */
    public function handle()
    {
        $issue = Issue::published()->latest('issue')->pluck('issue');
        $issueArticles = Issue::published()->latest()->first()->articles->groupBy('category_id');
        $recommendId = Category::recommend()->pluck('id');
        $otherId = Category::other()->pluck('id');
        $recommArticles = [];
        $normalArticles = collect(); // 创建一个新集合
        $otherArticles = [];
        foreach ($issueArticles as $key => $value) {
            if ($key == $recommendId) {
                // 推荐分类文章
                $recommArticles = $value;
            } elseif ($key == $otherId) {
                // 其他分类文章
                $otherArticles = $value;
            } else {
                $normalArticles = $normalArticles->merge($value);
            }
        }
        // 把推荐分类文章放在集合第一个  其他分类文章放在集合最后一个
        $articles = collect();
        $articles = $articles->merge($recommArticles)->merge($normalArticles)->merge($otherArticles)->groupBy('category_id');
        $users = Subscribe::where('is_confirmed', 1)->get();
        foreach ($users as $user) {
            $this->dispatch(new SendIssueEmail($user, $issue, $articles)); // 推送到队列
        }
    }
}
