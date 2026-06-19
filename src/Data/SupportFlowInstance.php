<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore\Data;

final readonly class SupportFlowInstance
{
    /**
     * @param array<int, string> $intents
     * @param array<string, mixed> $rules
     */
    public function __construct(
        public string $key,
        public string $label,
        public ?string $description,
        public array $intents,
        public array $rules = [],
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
            intents: array_values(array_map('strval', $data['intents'] ?? [])),
            rules: is_array($data['rules'] ?? null) ? $data['rules'] : [],
        );
    }
}
