# TaskMaster API - Документация

## Обзор

TaskMaster API - это масштабируемое REST API для управления задачами (To-Do List), построенное на Laravel с использованием современных архитектурных паттернов.

## Архитектура

Проект следует принципам чистой архитектуры и разделения ответственности:

- **Controllers** - обработка HTTP запросов
- **Services** - бизнес-логика
- **DTOs** - передача данных между слоями
- **Form Requests** - валидация входящих данных
- **Resources** - форматирование исходящих данных
- **Exceptions** - обработка ошибок
- **Models** - работа с базой данных

## Установка и настройка

### Требования
- PHP 8.2+
- Composer
- MySQL 8.0+
- Laravel 12.0+

### Установка

1. Клонируйте репозиторий:
```bash
git clone git@github.com:czybikzhap/TaskMasterAPI.git
cd TaskMasterAPI
```

2. Установите зависимости:
```bash
composer install
```

3. Настройте окружение:
```bash
cp .env.example .env
php artisan key:generate
```

4. Настройте базу данных в `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=taskmaster
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
5. Поднять контейнеры
```bash
docker-compose build
docker-compose up -d
```


6. Запустите миграции:
```bash
php artisan migrate
```


## API Endpoints

### Базовый URL
```
http://localhost:8086/api
```

### Аутентификация
В текущей версии аутентификация не требуется.

## Задачи (Tasks)

### 1. Получить все задачи
```http
GET /api/tasks
```

**Ответ:**
```json
{
    "success": true,
    "data": {
        "data": [
            {
                "id": 1,
                "title": "Название задачи",
                "description": "Описание задачи",
                "status": "pending",
                "status_label": "Ожидает выполнения",
                "created_at": "2025-10-15T00:00:00.000000Z",
                "updated_at": "2025-10-15T00:00:00.000000Z",
                "created_at_human": "2 часа назад",
                "updated_at_human": "2 часа назад"
            }
        ],
        "pagination": {
            "total": 1,
            "count": 1,
            "per_page": 15,
            "current_page": 1,
            "total_pages": 1
        }
    },
    "message": "Задачи успешно получены"
}
```

### 2. Создать задачу
```http
POST /api/tasks
Content-Type: application/json
```

**Тело запроса:**
```json
{
    "title": "Новая задача",
    "description": "Описание новой задачи",
    "status": "pending"
}
```

**Ответ:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "Новая задача",
        "description": "Описание новой задачи",
        "status": "pending",
        "status_label": "Ожидает выполнения",
        "created_at": "2025-10-15T00:00:00.000000Z",
        "updated_at": "2025-10-15T00:00:00.000000Z",
        "created_at_human": "только что",
        "updated_at_human": "только что"
    },
    "message": "Задача успешно создана",
    "meta": {
        "version": "1.0",
        "timestamp": "2025-10-15T01:00:00.000000Z"
    }
}
```

### 3. Получить задачу по ID
```http
GET /api/tasks/{id}
```

**Ответ:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "Название задачи",
        "description": "Описание задачи",
        "status": "pending",
        "created_at": "2025-10-15T00:00:00.000000Z",
        "updated_at": "2025-10-15T00:00:00.000000Z"
    },
    "message": "Задача успешно получена"
}
```

### 4. Обновить задачу
```http
PUT /api/tasks/{id}
Content-Type: application/json
```

**Тело запроса:**
```json
{
    "title": "Обновленное название",
    "description": "Обновленное описание",
    "status": "in_progress"
}
```

**Ответ:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "Обновленное название",
        "description": "Обновленное описание",
        "status": "in_progress",
        "created_at": "2025-10-15T00:00:00.000000Z",
        "updated_at": "2025-10-15T00:00:00.000000Z"
    },
    "message": "Задача успешно обновлена"
}
```

### 5. Удалить задачу
```http
DELETE /api/tasks/{id}
```

**Ответ:**
```json
{
    "success": true,
    "message": "Задача успешно удалена"
}
```

### 6. Получить задачи по статусу
```http
GET /api/tasks/status/{status}
```

**Параметры:**
- `status`: `pending`, `in_progress`, или `completed`

**Ответ:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "Задача в процессе",
            "description": "Описание",
            "status": "in_progress",
            "created_at": "2025-10-15T00:00:00.000000Z",
            "updated_at": "2025-10-15T00:00:00.000000Z"
        }
    ],
    "message": "Задачи со статусом 'in_progress' успешно получены"
}
```

## Валидация данных

### Поля задачи

| Поле | Тип | Обязательное | Ограничения |
|------|-----|--------------|-------------|
| `title` | string | Да | 3-255 символов |
| `description` | string | Нет | до 1000 символов |
| `status` | string | Да | pending, in_progress, completed |

### Примеры ошибок валидации

**Некорректные данные:**
```json
{
    "title": "ab",
    "status": "invalid_status"
}
```

**Ответ с ошибками:**
```json
{
    "success": false,
    "message": "Ошибка валидации данных.",
    "errors": {
        "title": [
            "Название задачи должно содержать минимум 3 символа."
        ],
        "status": [
            "Статус должен быть одним из: pending, in_progress, completed."
        ]
    },
    "status_code": 422
}
```

## Обработка ошибок

API использует стандартизированный формат ответов для ошибок:

### Структура ошибки
```json
{
    "success": false,
    "message": "Описание ошибки",
    "errors": {
        "field": ["Детальное описание ошибки"]
    },
    "status_code": 400
}
```

## Resources

API использует Laravel Resources для форматирования данных:

### TaskResource
- Форматирует данные одной задачи
- Добавляет `status_label` (человекочитаемый статус)
- Добавляет `created_at_human` и `updated_at_human` (относительное время)
- Включает мета-информацию

### TaskCollection
- Форматирует коллекции задач
- Добавляет информацию о пагинации
- Включает сводку по статусам в мета-данных

### TaskStatisticsResource
- Форматирует статистику задач
- Добавляет процентное распределение по статусам
- Включает детальную информацию о каждом статусе

### Коды ошибок

| Код | Описание |
|-----|----------|
| 400 | Неверный запрос |
| 404 | Ресурс не найден |
| 405 | Метод не разрешен |
| 422 | Ошибка валидации |
| 500 | Внутренняя ошибка сервера |

### Примеры ошибок

**Задача не найдена (404):**
```json
{
    "success": false,
    "message": "Задача с ID 999 не найдена.",
    "errors": {
        "task_id": ["Задача с ID 999 не существует."]
    },
    "status_code": 404
}
```

**Маршрут не найден (404):**
```json
{
    "success": false,
    "message": "Маршрут не найден.",
    "errors": {
        "route": ["Запрашиваемый маршрут не существует."]
    },
    "status_code": 404
}
```

## Примеры использования

### cURL

**Создание задачи:**
```bash
curl -X POST http://localhost:8000/api/tasks \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Изучить Laravel",
    "description": "Изучить основы фреймворка Laravel",
    "status": "pending"
  }'
```

**Получение всех задач:**
```bash
curl -X GET http://localhost:8000/api/tasks
```

**Обновление задачи:**
```bash
curl -X PUT http://localhost:8000/api/tasks/1 \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Изучить Laravel",
    "description": "Изучить основы фреймворка Laravel",
    "status": "completed"
  }'
```

**Удаление задачи:**
```bash
curl -X DELETE http://localhost:8000/api/tasks/1
```

### JavaScript (Fetch API)

**Создание задачи:**
```javascript
const createTask = async (taskData) => {
  const response = await fetch('http://localhost:8000/api/tasks', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(taskData)
  });
  
  return await response.json();
};

// Использование
const newTask = await createTask({
  title: 'Новая задача',
  description: 'Описание задачи',
  status: 'pending'
});
```

**Получение всех задач:**
```javascript
const getTasks = async () => {
  const response = await fetch('http://localhost:8000/api/tasks');
  return await response.json();
};
```

## Структура проекта

```
app/
├── DTOs/                    # Data Transfer Objects
│   ├── TaskDTO.php         # DTO для создания/обновления задач
│   └── TaskResponseDTO.php # DTO для ответов API
├── Exceptions/             # Обработка ошибок
│   ├── ApiException.php    # Базовое исключение API
│   ├── TaskNotFoundException.php # Исключение для ненайденных задач
│   └── Handler.php         # Глобальный обработчик исключений
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── TaskController.php # Контроллер задач
│   ├── Requests/
│   │   └── TaskRequest.php # Валидация запросов
│   └── Resources/          # Resources для форматирования ответов
│       ├── TaskResource.php # Resource для одной задачи
│       └── TaskCollection.php # Resource для коллекции задач
│    
├── Models/
│   └── Task.php           # Модель задачи
└── Services/
    └── TaskService.php    # Сервис бизнес-логики
```

## Архитектурные принципы

### 1. Разделение ответственности
- **Controller**: Обработка HTTP запросов и ответов
- **Service**: Бизнес-логика и операции с данными
- **DTO**: Типизированная передача данных
- **Form Request**: Валидация входящих данных

### 2. Dependency Injection
Сервисы внедряются в контроллеры через конструктор для лучшей тестируемости.

### 3. Единообразная обработка ошибок
Все ошибки обрабатываются централизованно через глобальный обработчик исключений.

### 4. Типизация данных
DTO обеспечивают строгую типизацию данных между слоями приложения.
