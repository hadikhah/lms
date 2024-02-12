<?php

namespace Modules\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Category\Http\Requests\CategoryRequest;
use Modules\Category\Models\Category;
use Modules\Category\Repositories\CategoryRepositoryInterface;
use Modules\Common\Responses\AjaxResponses;

class CategoryController extends Controller
{
    public CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * renders category index view
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     * @throws AuthorizationException
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('manage', Category::class);

        $categories = $this->categoryRepository->all();

        return view('Categories::index', compact('categories'));
    }

    /**
     * store new category into categories table
     *
     * @param CategoryRequest $request
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $this->authorize('manage', Category::class);

        $this->categoryRepository->create($request->validated());

        return back();
    }

    /**
     * renders category edit page
     *
     * @param $categoryId
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     * @throws AuthorizationException
     */
    public function edit($categoryId): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('manage', Category::class);

        $category = $this->categoryRepository->find($categoryId);

        $categories = $this->categoryRepository->allExceptById($categoryId);

        return view('Categories::edit', compact('category', 'categories'));
    }

    /**
     * updates existing category
     *
     * @param                 $categoryId
     * @param CategoryRequest $request
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update($categoryId, CategoryRequest $request): RedirectResponse
    {
        $this->authorize('manage', Category::class);

        $this->categoryRepository->update($request->validated(), $categoryId);

        return back();
    }

    /**
     * deletes category
     *
     * @param $categoryId
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy($categoryId): JsonResponse
    {
        $this->authorize('manage', Category::class);

        $this->categoryRepository->delete($categoryId);

        return AjaxResponses::SuccessResponse();
    }
}
