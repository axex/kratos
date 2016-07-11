<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $latestIssues = Issue::latest('issue')->published()->get();
        return view('frontend.index', compact('latestIssues'));
    }
}
