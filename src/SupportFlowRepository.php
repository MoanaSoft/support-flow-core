<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\Collection;
use Moanasoft\SupportFlowCore\Contracts\SupportFlowRepositoryContract;
use Moanasoft\SupportFlowCore\Data\SupportFlowInstance;
use Moanasoft\SupportFlowCore\Data\SupportFlowIntent;

final readonly class SupportFlowRepository implements SupportFlowRepositoryContract
{
    public function __construct(
        private ConfigRepository $config,
    ) {
    }

    public function instance(string $key): ?SupportFlowInstance
    {
        $data = $this->config->get('support-flow.instances.'.$key);

        if (! is_array($data)) {
            return null;
        }

        return SupportFlowInstance::fromArray($key, $data);
    }

    public function intent(string $key): ?SupportFlowIntent
    {
        $data = $this->config->get('support-flow.intents.'.$key);

        if (! is_array($data)) {
            return null;
        }

        return SupportFlowIntent::fromArray($key, $data);
    }

    public function intentsForInstance(string $instance): Collection
    {
        $definition = $this->instance($instance);

        if ($definition === null) {
            return collect();
        }

        return collect($definition->intents)
            ->map(fn (string $intent): ?SupportFlowIntent => $this->intent($intent))
            ->filter()
            ->values();
    }

    public function workflow(string $key): ?array
    {
        $data = $this->config->get('support-flow.workflows.'.$key);

        return is_array($data) ? $data : null;
    }
}
