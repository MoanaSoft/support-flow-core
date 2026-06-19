<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Moanasoft\SupportFlowCore\Actions\CreateSupportFlowRequest;
use Moanasoft\SupportFlowCore\Actions\RecordSupportFlowEvent;
use Moanasoft\SupportFlowCore\Contracts\SupportFlowRepositoryContract;
use Moanasoft\SupportFlowCore\Enums\SupportFlowEventType;

final class SupportFlowWidgetController extends Controller
{
    public function __construct(
        private readonly SupportFlowRepositoryContract $repository,
        private readonly RecordSupportFlowEvent $events,
    ) {
    }

    public function show(string $instance): JsonResponse
    {
        $definition = $this->repository->instance($instance);

        abort_if($definition === null, 404);

        $this->events->handle($instance, SupportFlowEventType::Viewed);

        return response()->json([
            'instance' => $definition,
            'intents' => $this->repository->intentsForInstance($instance)->values(),
        ]);
    }

    public function intent(Request $request, string $instance, string $intent): JsonResponse
    {
        $instanceDefinition = $this->repository->instance($instance);
        $intentDefinition = $this->repository->intent($intent);

        abort_if($instanceDefinition === null || $intentDefinition === null, 404);
        abort_if(! in_array($intent, $instanceDefinition->intents, true), 404);

        $workflow = $intentDefinition->workflow !== null
            ? $this->repository->workflow($intentDefinition->workflow)
            : null;

        $this->events->handle(
            instance: $instance,
            eventType: SupportFlowEventType::IntentSelected,
            intent: $intent,
            workflow: $intentDefinition->workflow,
            payload: ['resolution' => $intentDefinition->resolution],
            context: $request->input('context', []),
        );

        if ($intentDefinition->workflow !== null) {
            $this->events->handle(
                instance: $instance,
                eventType: SupportFlowEventType::WorkflowStarted,
                intent: $intent,
                workflow: $intentDefinition->workflow,
                context: $request->input('context', []),
            );
        }

        return response()->json([
            'intent' => $intentDefinition,
            'workflow' => $workflow,
            'fallback_contact' => $workflow === null || $intentDefinition->resolution === 'fallback_contact',
        ]);
    }

    public function complete(Request $request, string $instance, string $workflow): JsonResponse
    {
        abort_if($this->repository->instance($instance) === null, 404);
        abort_if($this->repository->workflow($workflow) === null, 404);

        $this->events->handle(
            instance: $instance,
            eventType: SupportFlowEventType::WorkflowCompleted,
            intent: $request->string('intent')->toString() ?: null,
            workflow: $workflow,
            context: $request->input('context', []),
        );

        return response()->json(['ok' => true]);
    }

    public function contactOpened(Request $request, string $instance): JsonResponse
    {
        abort_if($this->repository->instance($instance) === null, 404);

        $this->events->handle(
            instance: $instance,
            eventType: SupportFlowEventType::ContactOpened,
            intent: $request->string('intent')->toString() ?: null,
            workflow: $request->string('workflow')->toString() ?: null,
            context: $request->input('context', []),
        );

        return response()->json(['ok' => true]);
    }

    public function contact(Request $request, string $instance, CreateSupportFlowRequest $createRequest): JsonResponse
    {
        abort_if($this->repository->instance($instance) === null, 404);

        $validated = $request->validate([
            'intent' => ['nullable', 'string', 'max:100'],
            'workflow' => ['nullable', 'string', 'max:100'],
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'context' => ['nullable', 'array'],
        ]);

        $supportRequest = $createRequest->handle(['instance' => $instance, ...$validated]);

        $this->events->handle(
            instance: $instance,
            eventType: SupportFlowEventType::ContactSent,
            intent: $validated['intent'] ?? null,
            workflow: $validated['workflow'] ?? null,
            payload: ['request_id' => $supportRequest->getKey()],
            context: $validated['context'] ?? [],
        );

        return response()->json([
            'ok' => true,
            'request_id' => $supportRequest->getKey(),
        ], 201);
    }
}
