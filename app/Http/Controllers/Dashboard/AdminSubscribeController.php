<?php

namespace App\Http\Controllers\Dashboard;

use App\Repositories\SubscribeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSubscribeController extends Controller
{
    protected $subscribeRepository;

    /**
     * AdminSubscribeController constructor.
     * @param SubscribeRepository $subscribeRepository
     */
    public function __construct(SubscribeRepository $subscribeRepository)
    {
        $this->subscribeRepository = $subscribeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribes = $this->subscribeRepository->paging();

        return view('dashboard.subscribe.index', compact('subscribes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->subscribeRepository->forceDelete($id);

        return redirect()->route('dashboard.dashboard.subscribe.index')->with('message', trans('validation.notice.delete_subscribe_success'));
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

        $this->subscribeRepository->destroy($checkedList);

        return redirect()->route('dashboard.dashboard.subscribe.index')->with('message', trans('validation.notice.delete_subscribe_success'));
    }
}