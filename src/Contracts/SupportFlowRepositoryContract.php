<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore\Contracts;

use Illuminate\Support\Collection;
use Moanasoft\SupportFlowCore\Data\SupportFlowInstance;
use Moanasoft\SupportFlowCore\Data\SupportFlowIntent;

interface SupportFlowRepositoryContract
{
    public function instance(string $key): ?SupportFlowInstance;

    public function intent(string $key): ?SupportFlowIntent;

    /**
     * @return Collection<int, SupportFlowIntent>
     */
    public function intentsForInstance(string $instance): Collection;

    /**
     * @return array<string, mixed>|null
     */
    public function workflow(string $key): ?array;
}
