<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore\Actions;

use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\Request;
use Moanasoft\SupportFlowCore\Models\SupportFlowRequest;

final readonly class CreateSupportFlowRequest
{
    public function __construct(
        private Request $request,
        private AuthFactory $auth,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public function handle(array $data): SupportFlowRequest
    {
        $user = $this->auth->guard()->user();

        return SupportFlowRequest::query()->create([
            'instance' => $data['instance'],
            'intent' => $data['intent'] ?? null,
            'workflow' => $data['workflow'] ?? null,
            'status' => 'open',
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'subject' => $data['subject'] ?? null,
            'message' => $data['message'] ?? null,
            'user_id' => $user?->getAuthIdentifier(),
            'guard' => config('auth.defaults.guard'),
            'ip_address' => $this->request->ip(),
            'payload' => $data,
            'context' => is_array($data['context'] ?? null) ? $data['context'] : [],
        ]);
    }
}
