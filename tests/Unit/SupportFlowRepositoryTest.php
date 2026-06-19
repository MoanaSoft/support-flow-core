<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore\Tests\Unit;

use Moanasoft\SupportFlowCore\Contracts\SupportFlowRepositoryContract;
use Moanasoft\SupportFlowCore\Tests\TestCase;

final class SupportFlowRepositoryTest extends TestCase
{
    public function test_it_resolves_configured_instance_intents(): void
    {
        $repository = app(SupportFlowRepositoryContract::class);

        $intents = $repository->intentsForInstance('footer_contact');

        $this->assertNotEmpty($intents);
        $this->assertSame('pickup_labels', $intents->first()->key);
    }
}
