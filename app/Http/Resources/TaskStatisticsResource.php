<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskStatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total' => $this->resource['total'],
            'pending' => $this->resource['pending'],
            'in_progress' => $this->resource['in_progress'],
            'completed' => $this->resource['completed'],
            'completion_rate' => $this->resource['completion_rate'],
            'completion_percentage' => $this->resource['completion_rate'] . '%',
            'status_distribution' => [
                'pending' => [
                    'count' => $this->resource['pending'],
                    'percentage' => $this->resource['total'] > 0 ? round(($this->resource['pending'] / $this->resource['total']) * 100, 2) : 0,
                    'label' => 'Ожидает выполнения'
                ],
                'in_progress' => [
                    'count' => $this->resource['in_progress'],
                    'percentage' => $this->resource['total'] > 0 ? round(($this->resource['in_progress'] / $this->resource['total']) * 100, 2) : 0,
                    'label' => 'В процессе'
                ],
                'completed' => [
                    'count' => $this->resource['completed'],
                    'percentage' => $this->resource['total'] > 0 ? round(($this->resource['completed'] / $this->resource['total']) * 100, 2) : 0,
                    'label' => 'Завершена'
                ]
            ]
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
                'generated_at' => now()->toISOString(),
            ],
        ];
    }
}
