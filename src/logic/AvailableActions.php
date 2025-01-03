<?php

namespace src\logic;

use src\exceptions\StatusActionException;
use src\logic\actions\AbstractAction;
use src\logic\actions\CancelAction;
use src\logic\actions\CompleteAction;
use src\logic\actions\DenyAction;
use src\logic\actions\ResponseAction;

class AvailableActions
{

    public const string STATUS_NEW = 'new'; // Новое
    public const string STATUS_CANCEL = 'cancel'; // Отменено
    public const string STATUS_IN_PROGRESS = 'in_progress'; // В работе
    public const string STATUS_COMPLETE = 'complete'; // Выполнено
    public const string STATUS_EXPIRED = 'expired'; // Провалено

    public const string ROLE_PERFORMER = 'performer';
    public const string ROLE_CLIENT = 'client';

    protected int|null $performerId;
    protected int|null $clientId;

    protected string|null $status;
    protected \DateTime|null $finishDate;

    /**
     * @throws StatusActionException
     */
    public function __construct(string $status, int $clientId, ?int $performerId)
    {
        $this->setStatus($status);
        $this->clientId = $clientId;
        $this->performerId = $performerId;
    }

    /**
     *
     * Функция вернет доступные действия, полученные на основании роли пользователя и статуса задания
     *
     * @param string $role - Роль текущего пользователя
     * @param int $id - Идентификатор текущего пользователя
     * @return AbstractAction[]
     * @throws StatusActionException
     */
    public function getAvailableActions(string $role, int $id): array
    {

        $this->checkRole($role);

        $statusActions = $this->statusAllowedAction($this->status);
        $roleAllowedActions = $this->roleAllowedActions($role);

        $allowedActions = array_intersect($statusActions, $roleAllowedActions);

        $allowedActions = array_filter($allowedActions, function ($action) use ($id) {
            return $action::checkRights($id, $this->performerId, $this->clientId);
        });

        return array_values($allowedActions);

    }

    /**
     * Функция возвращает статус, в который перейдет задание при выполнении указанного действия
     *
     * @param AbstractAction $action
     * @return string|null
     */
    public function getNextStatus(AbstractAction $action): ?string
    {
        return match ($action::class) {
            ResponseAction::class => self::STATUS_IN_PROGRESS,
            CompleteAction::class => self::STATUS_COMPLETE,
            CancelAction::class, DenyAction::class => self::STATUS_CANCEL,
            default => null,
        };
    }

    /**
     * Функция возвращает карту статусов с именами на русском
     *
     * @return string[]
     */
    private function getStatusesMap(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCEL => 'Отменено',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_COMPLETE => 'Выполнено',
            self::STATUS_EXPIRED => 'Провалено',
        ];
    }

    /**
     * Функция возвращает список доступных действий для переданного статуса
     *
     * @param string $status
     * @return AbstractAction[]
     */
    private function statusAllowedAction(string $status): array
    {
        return match ($status) {
            self::STATUS_NEW => [CancelAction::class, ResponseAction::class],
            self::STATUS_IN_PROGRESS => [DenyAction::class, CompleteAction::class],
            default => []
        };
    }

    /**
     * Функция возвращает список доступных действий для переданной роли
     *
     * @param string $role
     * @return AbstractAction[]
     */
    public function roleAllowedActions(string $role): array
    {
        return match ($role) {
            self::ROLE_CLIENT => [CancelAction::class, CompleteAction::class],
            self::ROLE_PERFORMER => [DenyAction::class, ResponseAction::class],
            default => []
        };
    }

    /**
     * Функция устанавливает статус, если такой есть у класса
     *
     * @param string $status
     * @return void
     * @throws StatusActionException
     */
    private function setStatus(string $status): void
    {
        $availableStatuses = [self::STATUS_NEW, self::STATUS_CANCEL, self::STATUS_IN_PROGRESS, self::STATUS_COMPLETE,
            self::STATUS_EXPIRED];

        if (!in_array($status, $availableStatuses)) {
            throw new StatusActionException("Unknown status $status");
        }

        $this->status = $status;
    }

    /**
     *
     * Функция проверяет, что переданная роль указана корректно
     *
     * @param string $role
     * @return void
     * @throws StatusActionException
     */
    private function checkRole(string $role): void
    {
        $availableRoles = [self::ROLE_PERFORMER, self::ROLE_CLIENT];

        if (!in_array($role, $availableRoles)) {
            throw new StatusActionException("Unknown role $role");
        }
    }

}
