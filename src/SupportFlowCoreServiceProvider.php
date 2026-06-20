<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore;

use Illuminate\Support\Facades\Blade;
use Moanasoft\Foundation\Package\MoanasoftPackageServiceProvider;
use Moanasoft\SupportFlowCore\Contracts\SupportFlowRepositoryContract;
use Moanasoft\Foundation\Routing\PackageRouteRegistrar;

final class SupportFlowCoreServiceProvider extends MoanasoftPackageServiceProvider
{
    protected function packageName(): string
    {
        return 'support-flow-core';
    }

    protected function packageBasePath(): string
    {
        return dirname(__DIR__);
    }

    protected function packageDisplayName(): string
    {
        return 'Moanasoft SupportFlow Core';
    }

    protected function packageVersion(): string
    {
        return '0.3.0';
    }

    protected function packageDescription(): ?string
    {
        return 'Embeddable support qualification engine with multi-instance workflows, fallback contact and basic analytics.';
    }

    protected function configKey(): string
    {
        return 'support-flow';
    }

    protected function packageFeatures(): array
    {
        return [
            'blade-widget',
            'multi-instances',
            'configured-intents',
            'guided-workflows',
            'fallback-contact',
            'basic-tracking',
            'classic-admin-theme',
            'adminlte-admin-theme',
        ];
    }

    protected function packageRequires(): array
    {
        return ['foundation'];
    }

    protected function packageProvides(): array
    {
        return ['support-flow', 'support-flow-core'];
    }

    protected function hasMigrations(): bool
    {
        return true;
    }

    protected function hasRoutes(): bool
    {
        return false;
    }

    protected function hasAssets(): bool
    {
        return true;
    }

    protected function registerPackage(): void
    {
        $this->app->singleton(SupportFlowRepositoryContract::class, SupportFlowRepository::class);
        $this->app->singleton(SupportFlowAdminView::class);
    }

    protected function bootPackage(): void
    {
        if ((bool) config($this->configKey().'.routes.enabled', true)) {
            PackageRouteRegistrar::register(
                (array) config($this->configKey().'.routes.public', []),
                $this->packageBasePath().'/routes/front.php',
            );

            PackageRouteRegistrar::register(
                (array) config($this->configKey().'.routes.admin', []),
                $this->packageBasePath().'/routes/admin.php',
            );
        }

        Blade::anonymousComponentPath($this->packageBasePath().'/resources/views/components', 'support-flow');
    }

    protected function packageDiagnostics(): array
    {
        return [
            'instances' => count((array) config('support-flow.instances', [])),
            'intents' => count((array) config('support-flow.intents', [])),
            'workflows' => count((array) config('support-flow.workflows', [])),
            'admin_theme' => config('support-flow.admin.theme', 'classic'),
        ];
    }
}
