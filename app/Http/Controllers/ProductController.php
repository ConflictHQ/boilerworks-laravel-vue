<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:products.view')->only(['index', 'show']);
        $this->middleware('permission:products.create')->only(['create', 'store']);
        $this->middleware('permission:products.edit')->only(['edit', 'update']);
        $this->middleware('permission:products.delete')->only('destroy');
    }

    public function index(): Response
    {
        return Inertia::render('Products/Index', [
            'products' => Product::with('category')
                ->orderBy('created_at', 'desc')
                ->paginate(25),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Products/Create', [
            'categories' => Category::orderBy('name')->get(['id', 'uuid', 'name']),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created.');
    }

    public function show(Product $product): Response
    {
        return Inertia::render('Products/Show', [
            'product' => $product->load('category', 'creator'),
        ]);
    }

    public function edit(Product $product): Response
    {
        return Inertia::render('Products/Edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(['id', 'uuid', 'name']),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted.');
    }
}
