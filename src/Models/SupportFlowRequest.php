<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore\Models;

use Illuminate\Database\Eloquent\Model;

class SupportFlowRequest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'payload' => 'array',
        'context' => 'array',
        'resolved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getTable(): string
    {
        return (string) config('support-flow.requests.table', 'support_flow_requests');
    }
}
