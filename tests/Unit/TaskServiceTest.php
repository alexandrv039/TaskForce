<?php

namespace Tests\Unit;

use App\Actions\ActionCancel;
use App\Actions\ActionComplete;
use App\Actions\ActionReject;
use App\Actions\ActionRespond;
use App\Actions\ActionStart;
use App\Enums\TaskStatuses;
use App\Exceptions\StatusActionException;
use App\Service\TaskService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TaskServiceTest extends TestCase
{
    private const int CUSTOMER_ID = 1;
    private const int EXECUTOR_ID = 2;
    private const int STRANGER_ID = 3;

    private const string STATUS_NEW = TaskStatuses::STATUS_NEW;
    private const string STATUS_IN_PROGRESS = TaskStatuses::STATUS_IN_PROGRESS;

    public function test_current_status_returns_status_from_constructor(): void
    {
        $service = $this->makeService(self::CUSTOMER_ID, self::STATUS_IN_PROGRESS);

        $this->assertSame(self::STATUS_IN_PROGRESS, $service->currentStatus());
    }

    /**
     * Основная логика прав: кто какие действия видит в каждом статусе.
     */
    #[DataProvider('availableActionsProvider')]
    public function test_available_actions_for_status(
        ?int $currentUserId,
        string $status,
        array $expected,
    ): void {
        $service = $this->makeService($currentUserId, $status);

        $this->assertSame($expected, $service->availableActionsForStatus($status));
    }

    public static function availableActionsProvider(): array
    {
        return [
            'заказчик видит отмену и запуск у нового задания' => [
                self::CUSTOMER_ID,
                self::STATUS_NEW,
                [ActionCancel::class, ActionStart::class],
            ],
            'исполнитель видит только отклик у нового задания' => [
                self::EXECUTOR_ID,
                self::STATUS_NEW,
                [ActionRespond::class],
            ],
            'заказчик видит завершение у задания в работе' => [
                self::CUSTOMER_ID,
                self::STATUS_IN_PROGRESS,
                [ActionComplete::class],
            ],
            'исполнитель видит отказ у задания в работе' => [
                self::EXECUTOR_ID,
                self::STATUS_IN_PROGRESS,
                [ActionReject::class],
            ],
            'посторонний не видит ничего' => [
                self::STRANGER_ID,
                self::STATUS_NEW,
                [],
            ],
            'гость (currentUserId = null) не видит ничего' => [
                null,
                self::STATUS_NEW,
                [],
            ],
        ];
    }

    /**
     * Регрессия на перепутанный порядок аргументов customerId/executorId:
     * заказчик не должен получать действия исполнителя, и наоборот.
     */
    public function test_customer_does_not_receive_executor_actions(): void
    {
        $customer = $this->makeService(self::CUSTOMER_ID, self::STATUS_NEW);
        $this->assertNotContains(ActionRespond::class, $customer->availableActionsForStatus(self::STATUS_NEW));

        $executor = $this->makeService(self::EXECUTOR_ID, self::STATUS_IN_PROGRESS);
        $this->assertNotContains(ActionComplete::class, $executor->availableActionsForStatus(self::STATUS_IN_PROGRESS));
    }

    #[DataProvider('nextStatusProvider')]
    public function test_get_next_status(string $action, string $expected): void
    {
        $service = $this->makeService(self::CUSTOMER_ID, self::STATUS_NEW);

        $this->assertSame($expected, $service->getNextStatus($action));
    }

    public static function nextStatusProvider(): array
    {
        return [
            'отмена -> canceled' => [ActionCancel::class, TaskStatuses::STATUS_CANCELED],
            'запуск -> in_progress' => [ActionStart::class, TaskStatuses::STATUS_IN_PROGRESS],
            'отказ -> failed' => [ActionReject::class, TaskStatuses::STATUS_FAILED],
            'завершение -> completed' => [ActionComplete::class, TaskStatuses::STATUS_COMPLETED],
        ];
    }

    public function test_get_next_status_for_unknown_action_keeps_current_status(): void
    {
        $service = $this->makeService(self::CUSTOMER_ID, self::STATUS_IN_PROGRESS);

        $this->assertSame(self::STATUS_IN_PROGRESS, $service->getNextStatus('unknown_action'));
    }

    public function test_unknown_status_exception(): void
    {
        $this->expectException(StatusActionException::class);
        $this->makeService(self::CUSTOMER_ID, 'unknown_status');
    }

    /**
     * Собирает сервис с заданной ролью текущего пользователя.
     */
    private function makeService(?int $currentUserId, string $status): TaskService
    {
        return new TaskService(
            self::CUSTOMER_ID,
            self::EXECUTOR_ID,
            $currentUserId,
            $status,
        );
    }

}
