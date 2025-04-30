<?php

namespace App\Enums;

enum TaskStatuses
{
    public const string STATUS_NEW = 'new'; // Новое
    public const string STATUS_CANCEL = 'cancel'; // Отменено
    public const string STATUS_IN_PROGRESS = 'in_progress'; // В работе
    public const string STATUS_COMPLETE = 'complete'; // Выполнено
    public const string STATUS_EXPIRED = 'expired'; // Провалено

    /**
     * Функция возвращает карту статусов с именами на русском
     *
     * @return string[]
     */
    public static function getStatusesMap(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCEL => 'Отменено',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_COMPLETE => 'Выполнено',
            self::STATUS_EXPIRED => 'Провалено',
        ];
    }

    public static function allStatuses(): array
    {
        return [
            self::STATUS_NEW,
            self::STATUS_CANCEL,
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETE,
            self::STATUS_EXPIRED,
        ];
    }
}
