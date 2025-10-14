<?php

namespace App\Exceptions;

class TaskNotFoundException extends ApiException
{
    public function __construct(int $taskId)
    {
        parent::__construct(
            message: "Задача с ID {$taskId} не найдена.",
            statusCode: 404,
            errors: ['task_id' => ["Задача с ID {$taskId} не существует."]]
        );
    }
}
