<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use App\DTOs\TaskDTO;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService
    ) {}

    public function index(): JsonResponse
    {
        $tasks = $this->taskService->getAllTasks();

        return response()->json([
            'success' => true,
            'data' => new TaskCollection($tasks),
            'message' => 'Задачи успешно получены'
        ]);
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $taskDTO = TaskDTO::fromArray($request->validated());
        $task = $this->taskService->createTask($taskDTO);

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task),
            'message' => 'Задача успешно создана'
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $task = $this->taskService->getTaskById((int) $id);

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task),
            'message' => 'Задача успешно получена'
        ]);
    }

    public function update(TaskRequest $request, string $id): JsonResponse
    {
        $taskDTO = TaskDTO::fromArray($request->validated());
        $task = $this->taskService->updateTask((int) $id, $taskDTO);

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task),
            'message' => 'Задача успешно обновлена'
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->taskService->deleteTask((int) $id);

        return response()->json([
            'success' => true,
            'message' => 'Задача успешно удалена'
        ]);
    }

    public function getByStatus(string $status): JsonResponse
    {
        $tasks = $this->taskService->getTasksByStatus($status);

        return response()->json([
            'success' => true,
            'data' => new TaskCollection($tasks),
            'message' => "Задачи со статусом '{$status}' успешно получены"
        ]);
    }

}
