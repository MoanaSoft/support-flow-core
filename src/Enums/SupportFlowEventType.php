<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore\Enums;

enum SupportFlowEventType: string
{
    case Viewed = 'viewed';
    case IntentSelected = 'intent_selected';
    case WorkflowStarted = 'workflow_started';
    case WorkflowCompleted = 'workflow_completed';
    case ContactOpened = 'contact_opened';
    case ContactSent = 'contact_sent';
}
