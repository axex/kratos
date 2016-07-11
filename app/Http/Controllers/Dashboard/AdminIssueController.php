<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Issue;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests\Dashboard;
use App\Http\Controllers\Controller;

class AdminIssueController extends Controller
{
    /**
     * AdminIssueController constructor.
     */
    public function __construct()
    {
        $this->middleware('deny403', ['except' => 'index']);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (\Input::get('kword')) {
            $kword = \Input::get('kword', '');
            $whereStr = "issue like '%" . $kword . "%'";
            $issues = Issue::whereRaw($whereStr)->paginate(\Cache::get('page_size', 10));
        } else {
            $issues = Issue::latest('issue')->paginate(\Cache::get('page_size', 10));
        }
        return view('dashboard.issue.index', compact('issues'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.issue.create');
    }

    /**
     * 发布日期没写则用当前时间
     *
     * @param Dashboard\IssueRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Dashboard\IssueRequest $request)
    {
        $publishedAt = $request->get('published_at');
        if (! $publishedAt) {
            $publishedAt = Carbon::now();
        }
        $status = Issue::create([
            'issue'         => $request->get('issue'),
            'published_at'  => $publishedAt
        ]);
        if ($status) {
            return redirect()->route('dashboard.issue.index')->with('message', trans('validation.notice.create_issue_success'));
        }
        return back()->with('fail', trans('validation.notice.database_error'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
        $issue = Issue::findOrFail($id);
        return view('dashboard.issue.edit', compact('issue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Dashboard\IssueRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Dashboard\IssueRequest $request, $id)
    {
        $issue = Issue::findOrFail($id);
        $publishedAt = $request->get('published_at');
        if (! $publishedAt) {
            $publishedAt = $issue->published_at;
        }
        $status = $issue->update([
            'issue' => $request->get('issue'),
            'published_at' => $publishedAt
        ]);
        if ($status) {
            return redirect()->route('dashboard.issue.index')->with('message', trans('validation.notice.update_issue_success'));
        }
        return back()->with('fail', trans('validation.notice.database_error'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $article = Issue::findOrFail($id);
        $article->delete();
        return redirect()->route('dashboard.issue.index')->with('message', trans('validation.notice.delete_issue_success'));
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
        Issue::whereIn('id', $checkedList)->delete();
        return redirect()->route('dashboard.issue.index')->with('message', trans('validation.notice.delete_issue_success'));
    }
}
