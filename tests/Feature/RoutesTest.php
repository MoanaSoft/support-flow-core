<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Moanasoft\SupportFlowCore\Tests\TestCase;

final class RoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_widget_instance_endpoint_returns_intents(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->getJson('/support-flow/instances/footer_contact')
            ->assertOk()
            ->assertJsonPath('instance.key', 'footer_contact');
    }
}
