<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Moanasoft\SupportFlowCore\Models\SupportFlowEvent;
use Moanasoft\SupportFlowCore\SupportFlowAdminView;

final class StatsController extends Controller
{
    public function __invoke(SupportFlowAdminView $view): View
    {
        $topIntents = SupportFlowEvent::query()
            ->select('intent', DB::raw('count(*) as total'))
            ->whereNotNull('intent')
            ->groupBy('intent')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $eventsByType = SupportFlowEvent::query()
            ->select('event_type', DB::raw('count(*) as total'))
            ->groupBy('event_type')
            ->orderBy('event_type')
            ->get();

        return view($view->resolve('stats'), [
            'topIntents' => $topIntents,
            'eventsByType' => $eventsByType,
        ]);
    }
}
