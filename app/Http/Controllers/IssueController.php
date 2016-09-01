<?php

namespace App\Http\Controllers;

use App\Repositories\PublishingArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\IssueRepository;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    protected $issueRepository;

    protected $articleRepository;

    public function __construct(
        IssueRepository $issueRepository,
        PublishingArticleRepository $articleRepository)
    {
        $this->issueRepository = $issueRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @param string $issue
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(CategoryRepository $categoryRepository, $issue)
    {
        $issueArticles = $this->articleRepository->articles($issue);
        $recommendedCategoryId = $categoryRepository->recommendedCategoryIdWithCache();
        $defaultCategoryId = $categoryRepository->defaultCategoryIdWithCache();
        $recommArticles = [];
        $normalArticles = collect(); // 创建一个新集合
        $otherArticles = [];
        foreach ($issueArticles as $key => $value) {
            if ($key == $recommendedCategoryId) {
                // 推荐分类文章
                $recommArticles = $value;
            } elseif ($key == $defaultCategoryId) {
                // 其他分类文章
                $otherArticles = $value;
            } else {
                $normalArticles = $normalArticles->merge($value);
            }
        }
        // 把推荐分类文章放在集合第一个  其他分类文章放在集合最后一个
        $articles = collect();
        $articles = $articles->merge($recommArticles)->merge($normalArticles)->merge($otherArticles)->groupBy('category_id');
        $latestIssues = $this->issueRepository->getIssues();
        return view('frontend.issues.index', compact('issue', 'articles', 'latestIssues'));
    }


    /**
     * 搜索页
     *
     * @link http://wenda.golaravel.com/question/1094
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $q = $request->get('q');

        if (! $q) {
            return back();
        }

        $articles = $this->articleRepository->search($q);
        $latestIssues = $this->issueRepository->getIssues();

        return view('frontend.issues.search', compact('q', 'articles', 'latestIssues'));
    }
}
