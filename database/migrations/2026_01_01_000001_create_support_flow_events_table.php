<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('support-flow.events.table', 'support_flow_events'), function (Blueprint $table): void {
            $table->id();
            $table->string('instance');
            $table->string('event_type');
            $table->string('intent')->nullable();
            $table->string('workflow')->nullable();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('guard')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 512)->nullable();
            $table->json('payload')->nullable();
            $table->json('context')->nullable();
            $table->timestamps();

            $table->index(['instance', 'event_type']);
            $table->index(['instance', 'intent']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('support-flow.events.table', 'support_flow_events'));
    }
};
