<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore\Data;

final readonly class SupportFlowIntent
{
    public function __construct(
        public string $key,
        public string $label,
        public ?string $description,
        public ?string $workflow,
        public string $resolution,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(string $key, array $data): self
    {
        return new self(
            key: $key,
            label: (string) ($data['label'] ?? $key),
            description: isset($data['description']) ? (string) $data['description'] : null,
            workflow: isset($data['workflow']) ? (string) $data['workflow'] : null,
            resolution: (string) ($data['resolution'] ?? 'fallback_contact'),
        );
    }
}
