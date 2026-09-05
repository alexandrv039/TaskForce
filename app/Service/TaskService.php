<?php

namespace App\Service;

use App\Actions\AbstractAction;
use App\Actions\ActionCancel;
use App\Actions\ActionComplete;
use App\Actions\ActionReject;
use App\Actions\ActionRespond;
use App\Actions\ActionStart;

class TaskService
{
    private const STATUS_NEW = 'new';
    private const STATUS_CANCELED = 'canceled';
    private const STATUS_IN_PROGRESS = 'in_progress';
    private const STATUS_COMPLETED = 'completed';
    private const STATUS_FAILED = 'failed';

    private string $status;
    private ?int $executorId; // идентификатор исполнителя
    private int $customerId; // идентификатор заказчика
    private ?int $currentUserId; // идентификатор текущего пользователя

    public function __construct(int $customerId, ?int $executorId, ?int $currentUserId, string $status = self::STATUS_NEW)
    {
        $this->executorId = $executorId;
        $this->customerId = $customerId;
        $this->currentUserId = $currentUserId;
        $this->status = $status;
    }

    public function currentStatus(): string
    {
        return $this->status;
    }

    public function getNextStatus(string $action): string
    {
        return match ($action) {
            ActionCancel::class => self::STATUS_CANCELED,
            ActionStart::class => self::STATUS_IN_PROGRESS,
            ActionReject::class => self::STATUS_FAILED,
            ActionComplete::class => self::STATUS_COMPLETED,
            default => $this->currentStatus()
        };
    }

    public function availableActionsForStatus($status): array
    {

        if (is_null($this->currentUserId)) return [];

        $actions = match ($status) {
            self::STATUS_NEW => [ActionCancel::class, ActionRespond::class, ActionStart::class],
            self::STATUS_IN_PROGRESS => [ActionReject::class, ActionComplete::class],
            default => []
        };


        /** @var AbstractAction[] $actions */
        return array_values(array_filter($actions, fn($action) => $action::canExecute($this->customerId, $this->executorId, $this->currentUserId)));

    }

    public function statusTitleMap(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_COMPLETED => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',
        ];
    }

}
