<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormDefinitionRequest;
use App\Http\Requests\UpdateFormDefinitionRequest;
use App\Models\FormDefinition;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class FormDefinitionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:forms.view')->only(['index', 'show']);
        $this->middleware('permission:forms.create')->only(['create', 'store']);
        $this->middleware('permission:forms.edit')->only(['edit', 'update']);
        $this->middleware('permission:forms.delete')->only('destroy');
    }

    public function index(): Response
    {
        return Inertia::render('Forms/Index', [
            'forms' => FormDefinition::withCount('submissions')
                ->orderBy('created_at', 'desc')
                ->paginate(25),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Forms/Create');
    }

    public function store(StoreFormDefinitionRequest $request): RedirectResponse
    {
        FormDefinition::create($request->validated());

        return redirect()
            ->route('forms.index')
            ->with('success', 'Form created.');
    }

    public function show(FormDefinition $form): Response
    {
        return Inertia::render('Forms/Show', [
            'form' => $form->loadCount('submissions')->load('creator'),
        ]);
    }

    public function edit(FormDefinition $form): Response
    {
        return Inertia::render('Forms/Edit', [
            'form' => $form,
        ]);
    }

    public function update(UpdateFormDefinitionRequest $request, FormDefinition $form): RedirectResponse
    {
        $form->update($request->validated());

        return redirect()
            ->route('forms.show', $form)
            ->with('success', 'Form updated.');
    }

    public function destroy(FormDefinition $form): RedirectResponse
    {
        $form->delete();

        return redirect()
            ->route('forms.index')
            ->with('success', 'Form deleted.');
    }
}
