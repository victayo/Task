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
        $tasks = factory(Task::class, $amt)->create();
        $this->stageRepo->markAsCompleted($stage);
        foreach ($tasks as $task){
            $this->assertNotNull($task->completed);
        }
    }
}
