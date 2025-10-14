<?php

namespace App\Services;

use App\DTOs\TaskDTO;
use App\Exceptions\TaskNotFoundException;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskService
{
    public function getAllTasks(): Collection
    {
        return Task::all();
    }

    public function getTaskById(int $id): Task
    {
        $task = Task::find($id);

        if (!$task) {
            throw new TaskNotFoundException($id);
        }

        return $task;
    }

    public function createTask(TaskDTO $taskDTO): Task
    {
        return Task::create($taskDTO->toArray());
    }

    public function updateTask(int $id, TaskDTO $taskDTO): Task
    {
        $task = Task::find($id);

        if (!$task) {
            throw new TaskNotFoundException($id);
        }

        $task->update($taskDTO->toArray());

        return $task->fresh();
    }

    public function deleteTask(int $id): bool
    {
        $task = Task::find($id);

        if (!$task) {
            throw new TaskNotFoundException($id);
        }

        return $task->delete();
    }

    public function getTasksByStatus(string $status): Collection
    {
        return Task::where('status', $status)->get();
    }

    public function getTaskStatistics(): array
    {
        $total = Task::count();
        $pending = Task::where('status', 'pending')->count();
        $inProgress = Task::where('status', 'in_progress')->count();
        $completed = Task::where('status', 'completed')->count();

        return [
            'total' => $total,
            'pending' => $pending,
            'in_progress' => $inProgress,
            'completed' => $completed,
            'completion_rate' => $total > 0 ? round(($completed / $total) * 100, 2) : 0
        ];
    }
}
