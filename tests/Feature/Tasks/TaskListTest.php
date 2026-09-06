<?php

namespace Feature\Tasks;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TaskListTest extends TestCase
{

    use RefreshDatabase;

    protected $tasks;
    protected const URI = '/';
    protected const TASK_COUNT = 5;

    protected function setUp(): void
    {
        parent::setUp();

        Task::factory()->count(self::TASK_COUNT)->create();

    }

    public function test_task_list_response()
    {

        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->get(self::URI);
        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertViewHas('tasks');

    }

    public function test_task_list_not_available_if_no_auth()
    {

        $response = $this->get(self::URI);
        $response->assertStatus(302);

    }

}
