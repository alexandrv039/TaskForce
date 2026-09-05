<?php

namespace App\Actions;

/**
 * Класс-действие отклик на задание, выполняется исполнителем
 */
class ActionRespond extends AbstractAction
{

    public function title(): string
    {
        return 'Откликнуться';
    }

    public function name(): string
    {
        return 'action_respond';
    }

    public static function canExecute(int $customerId, ?int $executorId, int $currentUserId): bool
    {
        return $currentUserId === $executorId;
    }
}
