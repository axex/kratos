<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionRequest;
use App\Repositories\ContributeArticleReponsitory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;

class SubmissionController extends Controller
{
    public function index()
    {
        return view('frontend.submission.add');
    }

    public function store(SubmissionRequest $request, ContributeArticleReponsitory $articleRepository)
    {
        $explodeTags = explode(',', str_replace('，', ',', $request->get('tags')));
        $articleRepository->getTagIds($explodeTags);
        // url 已经被提交过
        $url = $articleRepository->checkUrl($request->get('url'));
        if ($url) {
            return back()->with('repeatUrl', Lang::get('validation.custom.url.repeat'))->withInput();
        }
        $article = $articleRepository->create($request->except('tags'));

        // 中文逗号换成英文逗号并转为数组
        $explodeTags = explode(',', str_replace('，', ',', $request->get('tags')));
        foreach ($explodeTags as $tag) {
            $tags = $articleRepository->updateOrCreateTags(['name' => $tag]);
            $article->tags()->attach($tags->id);
        }

        return view('frontend.submission.done');
    }
}
