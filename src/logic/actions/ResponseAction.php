<?php

namespace src\logic\actions;

class ResponseAction extends AbstractAction
{

    public static function getLabel(): string
    {
        return 'Откликнуться';
    }

    public static function getInternalName(): string
    {
        return 'act_response';
    }

    public static function checkRights(int $userId, ?int $performerId, ?int $clientId): bool
    {
        return $userId === $performerId;
    }
}
