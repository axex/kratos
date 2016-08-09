<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\IssueRepository;

class IndexController extends Controller
{
    /**
     * @param IssueRepository $issueRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(IssueRepository $issueRepository)
    {
        $issues = $issueRepository->allIssues();
        return view('frontend.index', compact('issues'));
    }
}
