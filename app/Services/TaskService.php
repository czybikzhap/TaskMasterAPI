<?php

namespace App\Services;

use App\DTOs\TaskDTO;
use App\Exceptions\TaskNotFoundException;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

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

}
