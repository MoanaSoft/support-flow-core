<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore\Models;

use Illuminate\Database\Eloquent\Model;

class SupportFlowEvent extends Model
{
    protected $guarded = [];

    protected $casts = [
        'payload' => 'array',
        'context' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getTable(): string
    {
        return (string) config('support-flow.events.table', 'support_flow_events');
    }
}
