<?php

namespace App\DTOs;

class TaskDTO
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $status
    ) {}

    /**
     * Create TaskDTO from array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'] ?? null,
            status: $data['status']
        );
    }

    /**
     * Convert TaskDTO to array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }

    /**
     * Create TaskDTO for update operation
     */
    public static function forUpdate(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'] ?? null,
            status: $data['status']
        );
    }
}
