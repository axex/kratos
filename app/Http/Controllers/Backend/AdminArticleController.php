<?php

namespace App\Http\Controllers\Backend;

use App\Article;
use App\Category;
use App\Issue;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests\Backend;
use App\Http\Controllers\Controller;

class AdminArticleController extends Controller
{
    protected $indexView;
    protected $editView;
    protected $isCheck;

    public function __construct()
    {
        $this->middleware('deny403', ['except' => 'index']);
        $this->indexView = 'backend.article.index';
        $this->editView = 'backend.article.edit';
        $this->isCheck = 1;
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
     * 传入是否审核参数, 自己添加的文章都是审核通过, 投稿的文章是未审核
     *
     * @param int $isCheck
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        if (\Input::get('kword')) {
            $kword = \Input::get('kword', '');
            $whereStr = "title like '%" . e($kword) . "%'";
            $articles = Article::whereRaw($whereStr)->isCheck($this->isCheck)->paginate(\Cache::get('page_size', 10));
        } else {
            $articles = Article::isCheck($this->isCheck)->latest()->paginate(\Cache::get('page_size', 10));
        }
        return view($this->indexView, compact('articles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::latest()->get();
        $issues = Issue::latest('issue')->get();
        return view('backend.article.create', compact('categories', 'issues'));
    }

    /**
     * @param Backend\ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Backend\ArticleRequest $request)
    {
        $article = new Article();
        $status = $this->createOrUpdate($request, $article);
        return $status;
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
        $article = Article::findOrFail($id);
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
     * @param Backend\ArticleRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Backend\ArticleRequest $request, $id)
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