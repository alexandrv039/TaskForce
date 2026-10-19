<?php

namespace App\Service;

use App\Actions\AbstractAction;
use App\Actions\ActionCancel;
use App\Actions\ActionComplete;
use App\Actions\ActionReject;
use App\Actions\ActionRespond;
use App\Actions\ActionStart;
use App\Enums\TaskStatuses;
use App\Exceptions\StatusActionException;

class TaskService
{
    private string $status;
    private ?int $executorId; // идентификатор исполнителя
    private int $customerId; // идентификатор заказчика
    private ?int $currentUserId; // идентификатор текущего пользователя

    /**
     * @throws StatusActionException
     */
    public function __construct(int $customerId, ?int $executorId, ?int $currentUserId, $status = TaskStatuses::STATUS_NEW)
    {

        if (array_search($status, TaskStatuses::allStatuses()) === false) {
            throw new StatusActionException("Статус не существует");
        }

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
            ActionCancel::class => TaskStatuses::STATUS_CANCELED,
            ActionStart::class => TaskStatuses::STATUS_IN_PROGRESS,
            ActionReject::class => TaskStatuses::STATUS_FAILED,
            ActionComplete::class => TaskStatuses::STATUS_COMPLETED,
            default => $this->currentStatus()
        };
    }

    /**
     * @param $status
     * @return AbstractAction[]
     */
    public function availableActionsForStatus($status): array
    {

        if (is_null($this->currentUserId)) return [];

        $actions = match ($status) {
            TaskStatuses::STATUS_NEW => [ActionCancel::class, ActionRespond::class, ActionStart::class],
            TaskStatuses::STATUS_IN_PROGRESS => [ActionReject::class, ActionComplete::class],
            default => []
        };


        /** @var AbstractAction[] $actions */
        return array_values(array_filter($actions,
            fn($action) => $action::canExecute($this->customerId, $this->executorId, $this->currentUserId)));

    }

}
