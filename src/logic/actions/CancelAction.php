<?php

namespace src\logic\actions;

class CancelAction extends AbstractAction
{

    public static function getLabel(): string
    {
        return 'Отменено';
    }

    public static function getInternalName(): string
    {
        return 'act_cancel';
    }

    public static function checkRights(int $userId, ?int $performerId, ?int $clientId): bool
    {
        return $userId === $clientId;
    }
}
