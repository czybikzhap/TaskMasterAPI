<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = TaskResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'pagination' => [
                'total' => $this->collection->count(),
                'count' => $this->collection->count(),
                'per_page' => 15,
                'current_page' => 1,
                'total_pages' => 1,
            ],
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'version' => '1.0',
                'timestamp' => now()->toISOString(),
                'total_tasks' => $this->collection->count(),
                'status_summary' => $this->getStatusSummary(),
            ],
        ];
    }

    /**
     * Get status summary for the collection
     */
    private function getStatusSummary(): array
    {
        $summary = [
            'pending' => 0,
            'in_progress' => 0,
            'completed' => 0,
        ];

        foreach ($this->collection as $task) {
            $summary[$task->status]++;
        }

        return $summary;
    }
}
