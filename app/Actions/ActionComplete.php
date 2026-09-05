<?php

namespace App\Actions;

/**
 * Класс-действие завершение задания, выполняется заказчиком
 */
class ActionComplete extends AbstractAction
{

    public function title(): string
    {
        return 'Завершить';
    }

    public function name(): string
    {
        return 'action_complete';
    }

    public static function canExecute(int $customerId, ?int $executorId, int $currentUserId): bool
    {
        return $currentUserId === $customerId;
    }
}
