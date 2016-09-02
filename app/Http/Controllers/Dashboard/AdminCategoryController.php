<?php

namespace App\Http\Controllers\Dashboard;

use App\Repositories\CategoryRepository;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Http\Controllers\Controller;

class AdminCategoryController extends Controller
{
    protected $categoryRepository;

    /**
     * AdminCategoryController constructor.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->middleware('deny403', ['except' => 'index']);
        $this->categoryRepository = $categoryRepository;
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categoryRepository->paging('articles');
        return view('dashboard.category.index', compact('categories'));
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.category.create');
    }

    /**
     * @param CategoryRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->categoryRepository->create($request->all());
        if ($category) {
            return redirect()->route('dashboard.dashboard.category.index')->with('message', trans('validation.notice.create_category_success'));
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
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findOrFail($id);

        return view('dashboard.category.edit', compact('category'));
    }

    /**
     *
     * @param  CategoryRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->categoryRepository->findOrFail($id);
        $status = $this->categoryRepository->update($request->all(), $category->id);
        if ($status) {
            return redirect()->route('dashboard.dashboard.category.index')->with('message', trans('validation.notice.update_category_success'));
        }

        return back()->with('fail', trans('validation.notice.database_error'));
    }

    /**
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->categoryRepository->destroy($id);

        return redirect()->route('dashboard.dashboard.category.index')->with('message', trans('validation.notice.delete_category_success'));
    }
}
