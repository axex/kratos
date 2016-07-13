<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Issue;
use App\Repositories\ArticleRepository;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IssueController extends Controller
{
    public function index($issue)
    {
        // 查询构建器上的方法可以在 vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php 里查询
        // 对数据库操作的方法可以在 vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php 里查询
        // Carbon 相关的方法可以在 vendor/nesbot/carbon/src/Carbon/Carbon.php 里查询
        $issueArticles = Issue::where(['issue' => $issue])->published()->first()->articles->groupBy('category_id');
        $recommendId = Category::recommend()->value('id');
        $otherId = Category::other()->value('id');
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
        $latestIssues = Issue::latest('issue')->published()->get()->take(20);
        return view('frontend.issues.template', compact('issue', 'articles', 'latestIssues'));
    }


    /**
     * @link http://wenda.golaravel.com/question/1094
     * @param ArticleRepository $articleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(ArticleRepository $articleRepository)
    {
        $kwords = \Request::get('kword', '');
        $kwords = explode(' ', $kwords);
        $whereStr = '';
        foreach ($kwords as $k => $kword) {
            $whereStr .= "title like '%" . $kword . "%'";
            $k != (count($kwords) - 1) ? $whereStr .= ' or ' : '';
        }
        $articles = $articleRepository->search($whereStr, 15);
        $latestIssues = Issue::latest('issue')->published()->limit(20)->get();

        return view('frontend.issues.search', compact('articles', 'latestIssues'));
    }
}
