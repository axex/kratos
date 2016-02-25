<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Issue;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubmissionController extends Controller
{
    public function index()
    {
        return view('frontend.submission.add');
    }

    public function store(Requests\SubmissionRequest $request)
    {
        // url 已经被提交过
        $url = Article::where('url', $request->get('url'))->first();
        if ($url) {
            return back()->with('repeatUrl', $url->issue->issue)->withInput();
        }
        $category = Category::first();
        $issue = Issue::latest('published_at')->first();
        $article = Article::create(array_merge([
                'category_id' => $category->id,
                'issue_id' => $issue->id,
                'is_check' => 0
            ], $request->except('tags'))
        );

        // 中文逗号换成英文逗号并转为数组
        $explodeTags = explode(',', str_replace('，', ',', $request->get('tags')));
        foreach ($explodeTags as $tag) {
            $tags = Tag::updateOrCreate(['name' => $tag]);
            $article->tags()->attach($tags->id);
        }

        return view('frontend.submission.done');
    }
}
