<?php

namespace App\DTOs;

use App\Models\Task;

class TaskResponseDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $status,
        public readonly string $created_at,
        public readonly string $updated_at
    ) {}

    /**
     * Create TaskResponseDTO from Task model
     */
    public static function fromModel(Task $task): self
    {
        return new self(
            id: $task->id,
            title: $task->title,
            description: $task->description,
            status: $task->status,
            created_at: $task->created_at->toISOString(),
            updated_at: $task->updated_at->toISOString()
        );
    }

    /**
     * Convert TaskResponseDTO to array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Create collection of TaskResponseDTO from Task models
     */
    public static function fromCollection($tasks): array
    {
        return $tasks->map(function (Task $task) {
            return self::fromModel($task);
        })->toArray();
    }
}
