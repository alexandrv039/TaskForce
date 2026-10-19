<?php

namespace App\Enums;

enum TaskStatuses
{
    public const string STATUS_NEW = 'new'; // Новое
    public const string STATUS_CANCELED = 'cancel'; // Отменено
    public const string STATUS_IN_PROGRESS = 'in_progress'; // В работе
    public const string STATUS_COMPLETED = 'complete'; // Выполнено
    public const string STATUS_FAILED = 'failed'; // Провалено

    /**
     * Функция возвращает карту статусов с именами на русском
     *
     * @return string[]
     */
    public static function getStatusesMap(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_COMPLETED => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',
        ];
    }

    public static function allStatuses(): array
    {
        return [
            self::STATUS_NEW,
            self::STATUS_CANCELED,
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETED,
            self::STATUS_FAILED,
        ];
    }
}
