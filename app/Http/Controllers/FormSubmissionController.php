<?php

namespace App\Http\Controllers;

use App\Enums\FormStatus;
use App\Models\FormDefinition;
use App\Models\FormSubmission;
use App\Rules\ValidFormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FormSubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:forms.view')->only('index');
        $this->middleware('permission:forms.submit')->only(['create', 'store']);
    }

    public function index(FormDefinition $form): Response
    {
        return Inertia::render('Forms/Submissions/Index', [
            'form' => $form,
            'submissions' => $form->submissions()
                ->orderBy('created_at', 'desc')
                ->paginate(25),
        ]);
    }

    public function create(FormDefinition $form): Response
    {
        abort_unless($form->status === FormStatus::Published, 404);

        return Inertia::render('Forms/Submissions/Create', [
            'form' => $form,
        ]);
    }

    public function store(Request $request, FormDefinition $form): RedirectResponse
    {
        abort_unless($form->status === FormStatus::Published, 404);

        $validated = $request->validate([
            'data' => ['required', 'array', new ValidFormSubmission($form)],
        ]);

        FormSubmission::create([
            'form_definition_id' => $form->id,
            'data' => $validated['data'],
        ]);

        return redirect()
            ->route('forms.show', $form)
            ->with('success', 'Form submitted successfully.');
    }
}
