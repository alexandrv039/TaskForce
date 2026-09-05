<?php

namespace App\Actions;

/**
 * Класс-действие отказ от задания, выполняется исполнителем
 */
class ActionReject extends AbstractAction
{

    public function title(): string
    {
        return 'Отказаться';
    }

    public function name(): string
    {
        return 'action_reject';
    }

    public static function canExecute(int $customerId, ?int $executorId, int $currentUserId): bool
    {
        return $currentUserId === $executorId;
    }
}
