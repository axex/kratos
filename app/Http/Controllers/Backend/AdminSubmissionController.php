<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests\Backend;

/**
 * 因为和 AdminArticleController 非常像, 所以直接继承 AdminArticleController
 *
 * Class AdminSubmissionController
 * @package App\Http\Controllers\Backend
 */
class AdminSubmissionController extends AdminArticleController
{
    public function __construct()
    {
        $this->indexView = 'backend.submission.index';
        $this->editView = 'backend.submission.edit';
        $this->isCheck = 0;
    }

    /**
     *
     * @param int $isCheck
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return parent::index();
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
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return parent::edit($id);
    }

    /**
     * @param Backend\ArticleRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Backend\ArticleRequest $request, $id)
    {
        return parent::update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return parent::destroy($id);
    }

    /**
     * 批量删除
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function batchDelete(Request $request)
    {
        return parent::batchDelete($request);
    }
}
