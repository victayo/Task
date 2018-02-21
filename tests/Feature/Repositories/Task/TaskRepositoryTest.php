<?php

namespace Tests\Feature\Repositories\Task;

use App\Models\Stage;
use App\Models\Task;
use App\Repositories\Task\TaskRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var TaskRepository
     */
    protected $taskRepo;

    public function setUp(){
        parent::setUp();
        $this->taskRepo = new TaskRepository();
        factory(Stage::class)->create();
    }

    public function testCanGetCompleted(){
        $amt = 5;
        factory(Task::class, 2)->create(); //dummy uncompleted
        factory(Task::class, $amt)->create(['completed' => $this->faker->date()]);
        $result = $this->taskRepo->getCompleted();
        $this->assertEquals($amt, $result->count());
    }

    public function testCanGetUncompleted(){
        $amt = 5;
        factory(Task::class, $amt)->create();
        factory(Task::class, 2)->create(['completed' => now()]); //dummy completed
        $result = $this->taskRepo->getUncompleted();
        $this->assertEquals($amt, $result->count());
    }

    public function testTaskStartedOn(){
        $date = now()->toDateString();
        $dummyDate = now()->addDays(5);
        $amt = 5;
        factory(Task::class, $amt)->create(['start_date' => $date]);
        factory(Task::class, 4)->create(['start_date' => $dummyDate]); //dummy
        $result = $this->taskRepo->getTasksStartedOn($date);
        $this->assertEquals($amt, $result->count());
        $this->assertEquals($date, $result->first()->start_date);
    }

    public function testTaskStartedAfter(){
        $amt = 5;
        $date = now()->toDateString();
        $afterDates = now()->addDays($amt)->toDateString();
        factory(Task::class, $amt)->create(['start_date' => $afterDates]);
        factory(Task::class, 4)->create(['start_date' => $date]); //dummy
        $result = $this->taskRepo->getTasksStartedAfter($date);
        $this->assertEquals($amt, $result->count());
        $this->assertEquals($afterDates, $result->first()->start_date);
    }

    public function testTasksStartedBetween(){
        $amt = 5;
        $firstDate = now()->subDays($amt)->toDateString();
        $secondDate = now()->addDays($amt)->toDateString();
        factory(Task::class)->create(['start_date' => $firstDate]);
        factory(Task::class)->create(['start_date' => $secondDate]);
        factory(Task::class, 4)->create(['start_date' => now()->toDateString()]);
        $result = $this->taskRepo->getTasksStartedBetween($firstDate, $secondDate);

        $this->assertEquals(4, $result->count());
    }

    public function testTaskStartedBefore(){
        $amt = 5;
        $before = now()->subDays($amt)->toDateString();
        factory(Task::class, $amt)->create(['start_date' => $before]);
        $result = $this->taskRepo->getTasksStartedBefore(now()->toDateString());
        $this->assertEquals($amt, $result->count());
    }
}
