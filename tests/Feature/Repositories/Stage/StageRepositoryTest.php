<?php

namespace Tests\Feature\Repositories\Stage;

use App\Models\Stage;
use App\Models\Task;
use App\Repositories\Stage\StageRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StageRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var StageRepository
     */
    protected $stageRepo;

    public function setUp(){
        parent::setUp();
        $this->stageRepo = new StageRepository();
    }

    public function testMarkAsCompleted(){
        $amt = 5;
        $stage = factory(Stage::class)->create();
        factory(Task::class, $amt)->create();
        $result = $this->stageRepo->markAsCompleted($stage);
        $this->assertEquals($amt, $result->count());
        $result->map(function($r){
            $this->assertNotNull($r->completed);
        });
    }

    public function testMarkAsUncompleted(){
        $amt = 5;
        $stage = factory(Stage::class)->create();
        factory(Task::class, $amt)->create(['completed' => now()->toDateString()]);
        $result = $this->stageRepo->markAsUncompleted($stage);
        $this->assertEquals($amt, $result->count());
        $result->map(function($r){
            $this->assertNull($r->completed);
        });
    }

    public function testGetCompletedTask(){
        $amt = 5;
        $stage = factory(Stage::class)->create();
        factory(Task::class, $amt)->create(['completed' => now()->toDateString()]);
        factory(Task::class)->create(); //dummy
        $completed = $this->stageRepo->getCompletedTasks($stage);
        $this->assertNotNull($completed);
        $this->assertNotEmpty($completed->toArray());
        $this->assertEquals($amt, $completed->count());
    }

    public function testGetUncompletedTask(){
        $amt = 5;
        $stage = factory(Stage::class)->create();
        factory(Task::class, $amt)->create();
        factory(Task::class)->create(['completed' => now()->toDateString()]); //dummy
        $uncompleted = $this->stageRepo->getUncompletedTasks($stage);
        $this->assertNotNull($uncompleted);
        $this->assertNotEmpty($uncompleted->toArray());
        $this->assertEquals($amt, $uncompleted->count());
    }
}
