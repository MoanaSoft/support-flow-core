<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('support-flow.requests.table', 'support_flow_requests'), function (Blueprint $table): void {
            $table->id();
            $table->string('instance');
            $table->string('intent')->nullable();
            $table->string('workflow')->nullable();
            $table->string('status')->default('open');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('guard')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->json('payload')->nullable();
            $table->json('context')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['instance', 'status']);
            $table->index(['instance', 'intent']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('support-flow.requests.table', 'support_flow_requests'));
    }
};
