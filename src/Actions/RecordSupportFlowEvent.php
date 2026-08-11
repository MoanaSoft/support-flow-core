<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore\Actions;

use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\Request;
use Moanasoft\SupportFlowCore\Enums\SupportFlowEventType;
use Moanasoft\SupportFlowCore\Models\SupportFlowEvent;

final readonly class RecordSupportFlowEvent
{
    public function __construct(
        private Request $request,
        private AuthFactory $auth,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     * @param  array<string, mixed>  $context
     */
    public function handle(
        string $instance,
        SupportFlowEventType $eventType,
        ?string $intent = null,
        ?string $workflow = null,
        array $payload = [],
        array $context = [],
    ): SupportFlowEvent {
        $user = $this->auth->guard()->user();

        return SupportFlowEvent::query()->create([
            'instance' => $instance,
            'event_type' => $eventType->value,
            'intent' => $intent,
            'workflow' => $workflow,
            'user_id' => $user?->getAuthIdentifier(),
            'guard' => config('auth.defaults.guard'),
            'ip_address' => $this->request->ip(),
            'user_agent' => substr((string) $this->request->userAgent(), 0, 512),
            'payload' => config('support-flow.tracking.store_payload', true) ? $payload : null,
            'context' => config('support-flow.tracking.store_context', true) ? $context : null,
        ]);
    }
}
