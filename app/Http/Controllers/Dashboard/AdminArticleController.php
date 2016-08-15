<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\PublishingTag;
use App\Repositories\Dashboard\CatogoryRepository;
use App\Repositories\Dashboard\IssueRepository;
use App\Repositories\Dashboard\PublishingArticleRepository;
use App\Repositories\Dashboard\PublishingTagRepository;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\ArticleRequest;
use App\Http\Controllers\Controller;

class AdminArticleController extends Controller
{
    protected $indexView;
    protected $editView;
    protected $articleRepository;
    protected $issueRepository;
    protected $categoryRepository;

    /**
     * AdminArticleController constructor.
     * @param PublishingArticleRepository $articleRepository
     * @param CatogoryRepository $categoryRepository
     * @param IssueRepository $issueRepository
     */
    public function __construct(
        PublishingArticleRepository $articleRepository,
        CatogoryRepository $categoryRepository,
        IssueRepository $issueRepository
    ) {
        $this->middleware('deny403', ['except' => 'index']);
        $this->indexView = 'dashboard.article.index';
        $this->editView = 'dashboard.article.edit';
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->issueRepository = $issueRepository;
    }

    /**
     * 新建或者更新文章
     *
     * @param $request
     * @param $article
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function createOrUpdate($request, $article, $id = 0)
    {
        $article = formatArticle($request, $article);
        if (! $article->save()) {
            return back()->with('fail', trans('validation.notice.database_error'));
        }
        if ($request->get('tag')) {
            $tags = str_replace('，', ',', $request->get('tag')); // 中文逗号改为英文
            $tags = trim($tags, ',');   // 去除字符首尾的逗号
            $tags = explode(',', $tags);
            foreach ($tags as $key => $tag) {
                $tagId[$key] = Tag::firstOrCreate([   // firstOrCreate 在数据库中查找记录, 找到就返回记录, 没有就新建一个
                    'name' => $tag
                ]);
            }
            $tagId = collect($tagId)->map(function ($item) {
                return $item->id;
            });
            if ($id) {  // 判断是撰写文章还是修改文章, 修改文章的话会有 $id 传进来
                $article->tags()->sync($tagId->toArray());  // 同步中间表, 任何不在该数组中的ID对应记录将会从中间表中移除
            } else {
                $article->tags()->attach($tagId->toArray());   // 插入文章和标签的关联关系到中间表
            }
        }
        return redirect(route($this->indexView))->with('message', trans('validation.notice.publish_success'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        if ($q) {
            $articles = $this->articleRepository->search($q);
        } else {
            $articles = $this->articleRepository->all();
        }
        return view($this->indexView, compact('articles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = $this->categoryRepository->all();
        $issues = $this->issueRepository->all();
        return view('dashboard.article.create', compact('categories', 'issues'));
    }

    /**
     * @param ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleRequest $request)
    {
        $article = $this->articleRepository->create($request->all());
        if (! $article) {
            return back()->with('fail', trans('validation.notice.database_error'));
        }

        $tagItems = $request->get('tag');
        $tagItems = explode(',', $tagItems);
        foreach ($tagItems as $key => $tag) {
            $tags[$key] = $this->tagRepository->firstOrCreate([   // firstOrCreate 在数据库中查找记录, 找到就返回记录, 没有就新建一个
                'name' => $tag
            ]);
        }
        $tagIds = collect($tags)->map(function ($item) {
            return $item->id;
        });
        $article->tags()->attach($tagIds->toArray());   // 插入文章和标签的关联关系到中间表
        return redirect(route($this->indexView))->with('message', trans('validation.notice.publish_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $article = $this->articleRepository->findOrFail($id);
        $tag = $article->tags->implode('name', ',');
        $categories = Category::get()->filter(function ($item) use ($article) {
            // 去掉当前的目录 id
            if ($item->id !== $article->category->id) {
                return $item;
            }
        });
        $issues = Issue::latest('issue')->get()->filter(function ($item) use ($article) {
            if ($item->id !== $article->issue->id) {
                return $item;
            }
        });
        return view($this->editView, compact('article', 'tag', 'categories', 'issues'));
    }

    /**
     * @param Dashboard\ArticleRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Dashboard\ArticleRequest $request, $id)
    {
        $article = Article::findOrFail($id);
        $status = $this->createOrUpdate($request, $article, $id);
        return $status;
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return redirect()->route($this->indexView)->with('message', trans('validation.notice.delete_article_success'));
    }

    /**
     * 批量删除
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function batchDelete(Request $request)
    {
        $checkedList = explode(',', $request->get('checkedList'));
        Article::whereIn('id', $checkedList)->delete();
        return redirect()->route($this->indexView)->with('message', trans('validation.notice.delete_article_success'));
    }

}
