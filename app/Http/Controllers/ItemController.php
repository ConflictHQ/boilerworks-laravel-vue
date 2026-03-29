<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:items.view')->only(['index', 'show']);
        $this->middleware('permission:items.create')->only(['create', 'store']);
        $this->middleware('permission:items.edit')->only(['edit', 'update']);
        $this->middleware('permission:items.delete')->only('destroy');
    }

    public function index(): Response
    {
        return Inertia::render('Items/Index', [
            'items' => Item::with('category')
                ->orderBy('created_at', 'desc')
                ->paginate(25),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Items/Create', [
            'categories' => Category::orderBy('name')->get(['id', 'uuid', 'name']),
        ]);
    }

    public function store(StoreItemRequest $request): RedirectResponse
    {
        Item::create($request->validated());

        return redirect()
            ->route('items.index')
            ->with('success', 'Item created.');
    }

    public function show(Item $item): Response
    {
        return Inertia::render('Items/Show', [
            'item' => $item->load('category', 'creator'),
        ]);
    }

    public function edit(Item $item): Response
    {
        return Inertia::render('Items/Edit', [
            'item' => $item,
            'categories' => Category::orderBy('name')->get(['id', 'uuid', 'name']),
        ]);
    }

    public function update(UpdateItemRequest $request, Item $item): RedirectResponse
    {
        $item->update($request->validated());

        return redirect()
            ->route('items.show', $item)
            ->with('success', 'Item updated.');
    }

    public function destroy(Item $item): RedirectResponse
    {
        $item->delete();

        return redirect()
            ->route('items.index')
            ->with('success', 'Item deleted.');
    }
}
