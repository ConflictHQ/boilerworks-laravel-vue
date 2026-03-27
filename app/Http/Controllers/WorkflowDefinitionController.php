<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkflowDefinitionRequest;
use App\Http\Requests\UpdateWorkflowDefinitionRequest;
use App\Models\WorkflowDefinition;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class WorkflowDefinitionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:workflows.view')->only(['index', 'show']);
        $this->middleware('permission:workflows.create')->only(['create', 'store']);
        $this->middleware('permission:workflows.edit')->only(['edit', 'update']);
        $this->middleware('permission:workflows.delete')->only('destroy');
    }

    public function index(): Response
    {
        return Inertia::render('Workflows/Index', [
            'workflows' => WorkflowDefinition::withCount('instances')
                ->orderBy('created_at', 'desc')
                ->paginate(25),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Workflows/Create');
    }

    public function store(StoreWorkflowDefinitionRequest $request): RedirectResponse
    {
        WorkflowDefinition::create($request->validated());

        return redirect()
            ->route('workflows.index')
            ->with('success', 'Workflow created.');
    }

    public function show(WorkflowDefinition $workflow): Response
    {
        return Inertia::render('Workflows/Show', [
            'workflow' => $workflow->loadCount('instances')->load('creator'),
        ]);
    }

    public function edit(WorkflowDefinition $workflow): Response
    {
        return Inertia::render('Workflows/Edit', [
            'workflow' => $workflow,
        ]);
    }

    public function update(UpdateWorkflowDefinitionRequest $request, WorkflowDefinition $workflow): RedirectResponse
    {
        $workflow->update($request->validated());

        return redirect()
            ->route('workflows.show', $workflow)
            ->with('success', 'Workflow updated.');
    }

    public function destroy(WorkflowDefinition $workflow): RedirectResponse
    {
        $workflow->delete();

        return redirect()
            ->route('workflows.index')
            ->with('success', 'Workflow deleted.');
    }
}
