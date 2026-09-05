<?php

namespace App\Actions;

/**
 * Класс-действие отмена задания, выполняется заказчиком
 */
class ActionCancel extends AbstractAction
{

    public function title(): string
    {
        return 'Отменить';
    }

    public function name(): string
    {
        return 'action_cancel';
    }

    public static function canExecute(int $customerId, ?int $executorId, int $currentUserId): bool
    {
        return $currentUserId === $customerId;
    }
}
