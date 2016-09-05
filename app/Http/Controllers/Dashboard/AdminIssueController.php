<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\IssueRequest;
use App\Repositories\IssueRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminIssueController extends Controller
{
    protected $issueRepository;

    /**
     * AdminIssueController constructor.
     *
     * @param IssueRepository $issueRepository
     */
    public function __construct(IssueRepository $issueRepository)
    {
        $this->middleware('deny403', ['except' => 'index']);
        $this->issueRepository = $issueRepository;
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        if ($q) {
            $issues = $this->issueRepository->search(['issue' => $q]);
        } else {
            $issues = $this->issueRepository->paging('articles', 'issue');
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
     * @param IssueRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(IssueRequest $request)
    {
        $publishedAt = $request->get('published_at');
        if (!$publishedAt) {
            $publishedAt = Carbon::now();
        }

        $status = $this->issueRepository->create([
            'issue' => $request->get('issue'),
            'published_at' => $publishedAt
        ]);

        if ($status) {
            return redirect()->route('dashboard.dashboard.issue.index')->with('message', trans('validation.notice.create_issue_success'));
        }

        return back()->with('fail', trans('validation.notice.database_error'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $issue = $this->issueRepository->findOrFail($id);

        return view('dashboard.issue.edit', compact('issue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IssueRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(IssueRequest $request, $id)
    {
        $issue = $this->issueRepository->findOrFail($id);
        $publishedAt = $request->get('published_at');
        if (!$publishedAt) {
            $publishedAt = $issue->published_at;
        }

        $status = $this->issueRepository->update([
            'issue' => $request->get('issue'),
            'published_at' => $publishedAt
        ], $issue->id);

        if ($status) {
            return redirect()->route('dashboard.dashboard.issue.index')->with('message', trans('validation.notice.update_issue_success'));
        }

        return back()->with('message', trans('validation.notice.database_error'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $status = $this->issueRepository->destroy($id);
        if ($status) {
            return redirect()->route('dashboard.dashboard.issue.index')->with('message', trans('validation.notice.delete_issue_success'));
        }

        return redirect()->route('dashboard.dashboard.issue.index')->with('message', trans('validation.notice.database_error'));
    }

    /**
     * 批量删除
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function batchDelete(Request $request)
    {
        $checkedList = explode(',', $request->get('checkedList'));
        $status = $this->issueRepository->destroy($checkedList);
        if ($status) {
            return redirect()->route('dashboard.dashboard.issue.index')->with('message', trans('validation.notice.delete_issue_success'));
        }

        return redirect()->route('dashboard.dashboard.issue.index')->with('message', trans('validation.notice.database_error'));
    }
}
