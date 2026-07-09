# Диаграмма классов (доменная модель)

Диаграмма отражает предметную область TaskForce. Существующие сущности отмечены как `есть`, недостающие по
ТЗ — как `добавить`.

```mermaid
classDiagram
    class User {
        +int id
        +string name
        +string email
        +string password
        +Roles role
        +int city_id
        +string~null~ avatar
        +date~null~ birthday
        +string~null~ phone
        +string~null~ telegram
        +bool contacts_customer_only
        +int failed_count
        +datetime created_at
        +city() BelongsTo
        +tasksAsCustomer() HasMany
        +tasksAsExecutor() HasMany
        +responses() HasMany
        +specializations() BelongsToMany
        +rating() float
    }

    class City {
        +int id
        +string name
        +float lat
        +float lng
        +users() HasMany
        +tasks() HasMany
    }

    class Category {
        +int id
        +string name
        +string icon
        +tasks() HasMany
    }

    class Task {
        +int id
        +string title
        +string description
        +int category_id
        +int customer_id
        +int~null~ executor_id
        +int~null~ city_id
        +float~null~ lat
        +float~null~ lng
        +int~null~ price
        +date~null~ deadline
        +string status
        +customer() BelongsTo
        +executor() BelongsTo
        +city() BelongsTo
        +category() BelongsTo
        +responses() HasMany
        +files() HasMany
        +review() HasOne
    }

    class Response {
        +int id
        +int task_id
        +int executor_id
        +int~null~ price
        +string~null~ comment
        +bool is_rejected
        +datetime created_at
        +task() BelongsTo
        +executor() BelongsTo
    }

    class Review {
        +int id
        +int task_id
        +int executor_id
        +int customer_id
        +int rating
        +string comment
        +datetime created_at
        +task() BelongsTo
        +executor() BelongsTo
    }

    class TaskFile {
        +int id
        +int task_id
        +string path
        +task() BelongsTo
    }

    class Roles {
        <<enumeration>>
        EXECUTOR
        CUSTOMER
    }

    class TaskStatuses {
        <<enumeration>>
        STATUS_NEW
        STATUS_CANCEL
        STATUS_IN_PROGRESS
        STATUS_COMPLETE
        STATUS_EXPIRED
        +getStatusesMap() array
    }

    class TaskService {
        -string status
        -int~null~ executorId
        -int customerId
        +currentStatus() string
        +getNextStatus(action) string
        +availableActionsForStatus(status) array
    }

    class TaskPolicy {
        +cancel(user, task) bool
        +complete(user, task) bool
        +start(user, task) bool
        +respond(user, task) bool
    }

    City "1" --> "*" User : проживает
    City "1" --> "*" Task : локация
    Category "1" --> "*" Task : категория
    User "1" --> "*" Task : создаёт (customer)
    User "0..1" --> "*" Task : выполняет (executor)
    User "*" -- "*" Category : специализации
    Task "1" --> "*" Response : отклики
    User "1" --> "*" Response : откликается
    Task "1" --> "*" TaskFile : вложения
    Task "1" --> "0..1" Review : отзыв
    User "1" --> "*" Review : получает

    User ..> Roles : role
    Task ..> TaskStatuses : status
    TaskService ..> TaskStatuses : использует
    TaskPolicy ..> Task : защищает
```

## Статус сущностей

| Сущность                | Состояние | Комментарий                                                              |
|-------------------------|-----------|-------------------------------------------------------------------------|
| `User`                  | есть      | нужно дополнить полями профиля и `failed_count`                          |
| `City`                  | есть      | —                                                                       |
| `Category`              | есть      | связь с `Task` перевести на `category_id`                                |
| `Task`                  | есть      | добавить `executor_id`, `category_id`; связи `responses/files/review`   |
| `Response` (отклик)     | добавить  | 2.4, 2.8, список откликов на странице задания                           |
| `Review` (отзыв)        | добавить  | 2.5, рейтинг и список отзывов в профиле (4.7)                            |
| `TaskFile` (вложение)   | добавить  | 2.2, прикреплённые файлы                                                 |
| `user_categories` (pivot) | добавить | специализации исполнителя (4.7, 4.8)                                    |
| `Roles`, `TaskStatuses` | есть      | enum-ы                                                                   |
| `TaskService`           | есть      | конечный автомат статусов                                               |
| `TaskPolicy`            | есть      | правила доступа (Gates/Policies)                                         |
