<?php

namespace App\Service;

class TaskService
{
    private const STATUS_NEW = 'new';
    private const STATUS_CANCELED = 'canceled';
    private const STATUS_IN_PROGRESS = 'in_progress';
    private const STATUS_COMPLETED = 'completed';
    private const STATUS_FAILED = 'failed';

    private const ACTION_CANCEL = 'action_cancel'; // отменить заказчиком
    private const ACTION_RESPOND = 'action_respond'; // откликнуться исполнителем
    private const ACTION_COMPLETE = 'action_complete'; // выполнено - подтверждение заказчиком
    private const ACTION_REJECT = 'action_reject'; // отказаться - исполнителем

    private string $status;
    private int $executorId; // идентификатор исполнителя
    private int $customerId; // идентификатор заказчика

    public function __construct(int $executorId, int $customerId, string $status = self::STATUS_NEW)
    {
        $this->executorId = $executorId;
        $this->customerId = $customerId;
        $this->status = $status;
    }

    public function currentStatus(): string
    {
        return $this->status;
    }

    public function getNextStatus(string $action): string
    {
        return match ($action) {
            self::ACTION_CANCEL => self::STATUS_CANCELED,
            self::ACTION_RESPOND => self::STATUS_IN_PROGRESS,
            self::ACTION_REJECT => self::STATUS_FAILED,
            self::ACTION_COMPLETE => self::STATUS_COMPLETED,
        };
    }

    public function availableActionsForStatus($status): array
    {
        return match ($status) {
            self::STATUS_NEW => [self::ACTION_CANCEL, self::ACTION_RESPOND],
            self::STATUS_IN_PROGRESS => [self::ACTION_REJECT, self::ACTION_COMPLETE],
            default => []
        };
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

    public function actionTitleMap(): array
    {
        return [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPOND => 'Откликнуться',
            self::ACTION_COMPLETE => 'Выполнено',
            self::ACTION_REJECT => 'Отказаться',
        ];
    }

}
