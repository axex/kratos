<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;

use App\Http\Requests\Dashboard;
use App\Http\Controllers\Controller;

class AdminCategoryController extends Controller
{
    /**
     * AdminCategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('deny403', ['except' => 'index']);
    }


    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::latest()->paginate(\Cache::get('page_size', 10));
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
     * @param Dashboard\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Dashboard\CategoryRequest $request)
    {
        $category = Category::create($request->all());
        if ($category) {
            return redirect()->route('dashboard.category.index')->with('message', trans('validation.notice.create_category_success'));
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
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.category.edit', compact('category'));
    }

    /**
     *
     * @param  Dashboard\CategoryRequest $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Dashboard\CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $status = $category->update($request->all());
        if ($status) {
            return redirect()->route('dashboard.category.index')->with('message', trans('validation.notice.update_category_success'));
        }
        return back()->with('fail', trans('validation.notice.database_error'));
    }

    /**
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('dashboard.category.index')->with('message', trans('validation.notice.delete_category_success'));
    }
}
