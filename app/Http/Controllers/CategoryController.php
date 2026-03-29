<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:categories.view')->only(['index', 'show']);
        $this->middleware('permission:categories.create')->only(['create', 'store']);
        $this->middleware('permission:categories.edit')->only(['edit', 'update']);
        $this->middleware('permission:categories.delete')->only('destroy');
    }

    public function index(): Response
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::withCount('items')
                ->orderBy('created_at', 'desc')
                ->paginate(25),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Categories/Create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created.');
    }

    public function show(Category $category): Response
    {
        return Inertia::render('Categories/Show', [
            'category' => $category->loadCount('items')->load('creator'),
        ]);
    }

    public function edit(Category $category): Response
    {
        return Inertia::render('Categories/Edit', [
            'category' => $category,
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()
            ->route('categories.show', $category)
            ->with('success', 'Category updated.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted.');
    }
}
