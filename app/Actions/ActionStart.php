<?php

namespace App\Actions;

/**
 * Класс-действие старт задания, выполняется заказчиком
 */
class ActionStart extends AbstractAction
{

    public function title(): string
    {
        return 'Запустить';
    }

    public function name(): string
    {
        return 'action_start';
    }

    public static function canExecute(int $customerId, ?int $executorId, int $currentUserId): bool
    {
        return $currentUserId === $customerId;
    }
}
