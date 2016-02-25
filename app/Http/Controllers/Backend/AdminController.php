<?php

namespace App\Http\Controllers\Backend;

use App\Article;
use App\Subscribe;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function console()
    {
        $carbon = new Carbon();
        $startOfWeek = $carbon->startOfWeek()->toDateTimeString();
        $endOfWeek = $carbon->endOfWeek()->toDateTimeString();
        $subscribes = Subscribe::where('is_confirmed', 1)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $articles = Article::isCheck(1)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $submissions = Article::isCheck(0)->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        return view('backend.console', compact('subscribes', 'articles', 'submissions'));
    }


}
