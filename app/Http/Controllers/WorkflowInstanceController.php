<?php

namespace App\Http\Controllers;

use App\Models\WorkflowDefinition;
use App\Models\WorkflowInstance;
use App\Services\WorkflowTransitionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WorkflowInstanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:workflows.view')->only('index');
        $this->middleware('permission:workflows.create')->only('store');
        $this->middleware('permission:workflows.transition')->only('transition');
    }

    public function index(WorkflowDefinition $workflow): Response
    {
        return Inertia::render('Workflows/Instances/Index', [
            'workflow' => $workflow,
            'instances' => $workflow->instances()
                ->with('transitionLogs')
                ->orderBy('created_at', 'desc')
                ->paginate(25),
        ]);
    }

    public function store(Request $request, WorkflowDefinition $workflow): RedirectResponse
    {
        $validated = $request->validate([
            'workflowable_type' => ['nullable', 'string', 'max:255'],
            'workflowable_id' => ['nullable', 'integer'],
        ]);

        $initialState = collect($workflow->states)
            ->firstWhere('is_initial', true);

        abort_unless($initialState, 422, 'Workflow has no initial state defined.');

        WorkflowInstance::create([
            'workflow_definition_id' => $workflow->id,
            'workflowable_type' => $validated['workflowable_type'] ?? null,
            'workflowable_id' => $validated['workflowable_id'] ?? null,
            'current_state' => $initialState['name'],
        ]);

        return redirect()
            ->route('workflows.instances.index', $workflow)
            ->with('success', 'Workflow instance created.');
    }

    public function transition(
        Request $request,
        WorkflowDefinition $workflow,
        WorkflowInstance $instance,
        WorkflowTransitionService $transitionService,
    ): RedirectResponse {
        $validated = $request->validate([
            'to_state' => ['required', 'string', 'max:255'],
        ]);

        $transitionService->transition($instance, $validated['to_state']);

        return redirect()
            ->route('workflows.instances.index', $workflow)
            ->with('success', 'Transition completed.');
    }
}
