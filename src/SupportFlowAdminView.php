<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore;

use Illuminate\Contracts\View\Factory as ViewFactory;

final readonly class SupportFlowAdminView
{
    public function __construct(
        private ViewFactory $view,
    ) {}

    public function resolve(string $view): string
    {
        $theme = (string) config('support-flow.admin.theme', 'classic');
        $theme = $theme === 'adminlte' ? 'adminlte' : 'blade';
        $candidate = 'support-flow::'.$theme.'.admin.'.$view;

        if ($this->view->exists($candidate)) {
            return $candidate;
        }

        return 'support-flow::blade.admin.'.$view;
    }
}
