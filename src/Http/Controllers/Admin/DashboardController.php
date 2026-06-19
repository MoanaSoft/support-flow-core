<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Moanasoft\SupportFlowCore\Models\SupportFlowEvent;
use Moanasoft\SupportFlowCore\Models\SupportFlowRequest;
use Moanasoft\SupportFlowCore\SupportFlowAdminView;

final class DashboardController extends Controller
{
    public function __invoke(SupportFlowAdminView $view): View
    {
        return view($view->resolve('dashboard'), [
            'stats' => $this->stats(),
            'latestRequests' => SupportFlowRequest::query()->latest()->limit(10)->get(),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function stats(): array
    {
        $events = SupportFlowEvent::query();
        $views = (clone $events)->where('event_type', 'viewed')->count();
        $contactsSent = (clone $events)->where('event_type', 'contact_sent')->count();
        $workflowsCompleted = (clone $events)->where('event_type', 'workflow_completed')->count();
        $intentsSelected = (clone $events)->where('event_type', 'intent_selected')->count();

        return [
            'views' => $views,
            'intents_selected' => $intentsSelected,
            'workflows_started' => (clone $events)->where('event_type', 'workflow_started')->count(),
            'workflows_completed' => $workflowsCompleted,
            'contacts_opened' => (clone $events)->where('event_type', 'contact_opened')->count(),
            'contacts_sent' => $contactsSent,
            'deflection_rate' => $intentsSelected > 0 ? round((1 - ($contactsSent / max($intentsSelected, 1))) * 100, 2) : 0,
            'open_requests' => SupportFlowRequest::query()->where('status', 'open')->count(),
        ];
    }
}
