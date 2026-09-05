<?php

namespace App\Actions;

abstract class AbstractAction
{
    abstract public function title(): string;

    abstract public function name(): string;

    abstract static public function canExecute(int $customerId, ?int $executorId, int $currentUserId): bool;
}
