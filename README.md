# TaskMaster API

Масштабируемое REST API для управления задачами (To-Do List), построенное на Laravel с использованием современных архитектурных паттернов.

## 🚀 Особенности

- ✅ **Полный CRUD** для задач
- ✅ **Валидация данных** с кастомными сообщениями
- ✅ **Сервисный слой** для разделения бизнес-логики
- ✅ **DTO** для типизированной передачи данных
- ✅ **Глобальная обработка ошибок**
- ✅ **Дополнительные endpoints** (статистика, фильтрация)
- ✅ **Полная документация API**

## 📋 Требования

- PHP 8.2+
- Composer
- MySQL 8.0+
- Laravel 12.0+

## 🛠 Установка

1. **Клонируйте репозиторий:**
```bash
git clone <repository-url>
cd TaskMasterAPI
```

2. **Установите зависимости:**
```bash
composer install
```

3. **Настройте окружение:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Настройте базу данных в `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskmaster
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Запустите миграции:**
```bash
php artisan migrate
```

6. **Запустите сервер:**
```bash
php artisan serve
```

API будет доступно по адресу: `http://localhost:8000/api`

## 📚 API Endpoints

### Основные операции с задачами

| Метод | Endpoint | Описание |
|-------|----------|----------|
| GET | `/api/tasks` | Получить все задачи |
| POST | `/api/tasks` | Создать новую задачу |
| GET | `/api/tasks/{id}` | Получить задачу по ID |
| PUT | `/api/tasks/{id}` | Обновить задачу |
| DELETE | `/api/tasks/{id}` | Удалить задачу |

### Дополнительные endpoints

| Метод | Endpoint | Описание |
|-------|----------|----------|
| GET | `/api/tasks/status/{status}` | Получить задачи по статусу |
| GET | `/api/tasks/statistics` | Получить статистику задач |

## 🔧 Примеры использования

### Создание задачи
```bash
curl -X POST http://localhost:8000/api/tasks \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Изучить Laravel",
    "description": "Изучить основы фреймворка Laravel",
    "status": "pending"
  }'
```

### Получение всех задач
```bash
curl -X GET http://localhost:8000/api/tasks
```

### Обновление задачи
```bash
curl -X PUT http://localhost:8000/api/tasks/1 \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Изучить Laravel",
    "description": "Изучить основы фреймворка Laravel",
    "status": "completed"
  }'
```

## 📊 Структура данных

### Задача (Task)
```json
{
  "id": 1,
  "title": "Название задачи",
  "description": "Описание задачи",
  "status": "pending",
  "created_at": "2025-10-15T00:00:00.000000Z",
  "updated_at": "2025-10-15T00:00:00.000000Z"
}
```

### Статусы задач
- `pending` - Ожидает выполнения
- `in_progress` - В процессе выполнения
- `completed` - Завершена

## 🏗 Архитектура

Проект следует принципам чистой архитектуры:

```
app/
├── DTOs/                    # Data Transfer Objects
├── Exceptions/             # Обработка ошибок
├── Http/
│   ├── Controllers/Api/    # API контроллеры
│   └── Requests/           # Валидация запросов
├── Models/                 # Eloquent модели
└── Services/               # Бизнес-логика
```

### Компоненты

- **Controllers** - Обработка HTTP запросов
- **Services** - Бизнес-логика и операции с данными
- **DTOs** - Типизированная передача данных между слоями
- **Form Requests** - Валидация входящих данных
- **Exceptions** - Централизованная обработка ошибок

## ✅ Валидация

### Правила валидации
- `title`: обязательное, строка, 3-255 символов
- `description`: опциональное, строка, до 1000 символов
- `status`: обязательное, одно из: pending, in_progress, completed

### Пример ошибки валидации
```json
{
  "success": false,
  "message": "Ошибка валидации данных.",
  "errors": {
    "title": ["Название задачи должно содержать минимум 3 символа."],
    "status": ["Статус должен быть одним из: pending, in_progress, completed."]
  },
  "status_code": 422
}
```

## 🚨 Обработка ошибок

API использует стандартизированный формат ответов:

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

### Коды ошибок
- `400` - Неверный запрос
- `404` - Ресурс не найден
- `405` - Метод не разрешен
- `422` - Ошибка валидации
- `500` - Внутренняя ошибка сервера

## 🧪 Тестирование

```bash
# Запуск тестов
php artisan test

# Тестирование API
curl -X GET http://localhost:8000/api/tasks
```

## 📖 Документация

Полная документация API доступна в файле [API_DOCUMENTATION.md](./API_DOCUMENTATION.md)

## 🔒 Безопасность

- Валидация всех входящих данных
- Защита от SQL-инъекций через Eloquent ORM
- Безопасная обработка ошибок
- CORS настройки

## 🚀 Развертывание

### Production настройки

1. Обновите `.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

2. Оптимизируйте приложение:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📝 Лицензия

MIT License

## 🤝 Поддержка

Для вопросов и поддержки создайте issue в репозитории проекта.

---

**TaskMaster API** - Профессиональное решение для управления задачами с современной архитектурой и полной документацией.