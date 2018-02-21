<?php
/**
 * Created by PhpStorm.
 * User: mighty
 * Date: 2/21/2018
 * Time: 11:57 AM
 */

namespace App\Repositories\Stage;

use App\Models\Stage;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class StageRepository implements StageRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getAll()
    {
        return Stage::all();
    }

    /**
     * @param $id
     * @return Stage
     */
    public function getById($id)
    {
        return Stage::find($id);
    }

    /**
     * @param array $attributes
     * @return Stage
     */
    public function create(array $attributes) // TODO: check for default
    {
        return Stage::create($attributes);
    }

    /**
     * @param Stage $stage
     * @param array $attributes
     * @return bool
     */
    public function update(Stage $stage, array $attributes) // TODO: check for default
    {
         return $stage->update($attributes);
    }

    /**
     * @param Stage $stage
     * @return bool
     */
    public function delete(Stage $stage)
    {
        try{
            $stage->delete();
            return true;
        }catch (Exception $e){
            return false;
        }
    }

    /**
     * @param Stage $stage
     * @return Collection
     */
    public function getTasks(Stage $stage)
    {
        return $stage->tasks()->get();
    }

    /**
     * @param Task $task
     * @param Stage $_old
     * @param Stage $_new
     * @return bool
     */
    public function moveTask(Task $task, Stage $_old, Stage $_new)
    {
        if($task->stage_id != $_old->id){
            return false;
        }
        $task->stage_id = $_new->id;
        $task->save();
        return true;
    }

    /**
     * @param Stage $stage
     */
    public function markAsCompleted(Stage $stage)
    {
       $tasks = $stage->tasks()->get();
       $tasks->map(function($task){
           if(!$task->completed){
               $task->completed = now()->toDateString();
               $task->save();
           }
       });
    }

    /**
     * @param Stage $stage
     */
    public function markAsUncompleted(Stage $stage)
    {
        $tasks = $stage->tasks()->get();
        $tasks->map(function($task){
                $task->completed = null;
                $task->save();
        });
    }

    /**
     * @param Stage $stage
     * @return Collection
     */
    public function getCompletedTasks(Stage $stage)
    {
        return $stage->tasks()
            ->whereNotNull('tasks.completed')
            ->get();
    }

    /**
     * @param Stage $stage
     * @return Collection
     */
    public function getUncompletedTasks(Stage $stage)
    {
        return $stage->tasks()
            ->whereNull('tasks.completed')
            ->get();
    }

    /**
     * @param Stage $stage
     * @return float|int|null
     */
    public function getCompletedPercentage(Stage $stage)
    {
        $total = $this->getTasks()->count();
        if(!$total){
            return null;
        }
        $completed = $this->getCompletedTasks($stage);
        if(!$completed){
            return 0;
        }
        return ($completed/$total)*100;
    }

    /**
     * @param Stage $stage
     * @return float|int|null
     */
    public function getUncompletedPercentage(Stage $stage)
    {
        $total = $this->getTasks()->count();
        if(!$total){
            return null;
        }
        $uncompleted = $this->getUncompletedTasks($stage);
        if(!$uncompleted){
            return 0;
        }
        return ($uncompleted/$total)*100;
    }

    /**
     * @return Stage
     */
    public function getDefaultStage()
    {
        return Stage::where('default', true)->first();
    }

    /**
     * @param Stage $stage
     */
    public function setDefaultStage(Stage $stage)
    {
        $default = $this->getDefaultStage();
        if($default){
            $default->default = false;
            $default->save();
        }
        $stage->default = true;
        $stage->save();
    }

    /**
     * @param Stage $stage
     * @return bool
     */
    public function isDefault(Stage $stage)
    {
        return $stage->default;
    }
}