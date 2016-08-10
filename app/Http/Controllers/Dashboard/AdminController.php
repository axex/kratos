<?php

namespace App\Http\Controllers\Dashboard;

use App\Repositories\Dashboard\ContributeArticleRepository;
use App\Repositories\Dashboard\PublishingArticleRepository;
use App\Repositories\Dashboard\SubscribeRepository;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $subscribeRepository;
    protected $publishingArticleRepository;
    protected $contributeArticleRepository;

    /**
     * AdminController constructor.
     * @param SubscribeRepository $subscribeRepository
     * @param PublishingArticleRepository $publishingArticleRepository
     * @param ContributeArticleRepository $contributeArticleRepository
     */
    public function __construct(
        SubscribeRepository $subscribeRepository,
        PublishingArticleRepository $publishingArticleRepository,
        ContributeArticleRepository $contributeArticleRepository
    ) {
        $this->subscribeRepository = $subscribeRepository;
        $this->publishingArticleRepository = $publishingArticleRepository;
        $this->contributeArticleRepository = $contributeArticleRepository;
    }


    public function console()
    {
        $carbon = new Carbon();
        $startOfWeek = $carbon->startOfWeek()->toDateTimeString();
        $endOfWeek = $carbon->endOfWeek()->toDateTimeString();
        $weekly = [$startOfWeek, $endOfWeek];
        $subscribes = $this->subscribeRepository->count($weekly);
        $publishingArticles = $this->publishingArticleRepository->count($weekly);
        $contributeArticles = $this->contributeArticleRepository->count($weekly);
        return view('dashboard.console', compact('subscribes', 'publishingArticles', 'contributeArticles'));
    }


}
