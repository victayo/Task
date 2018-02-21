<?php
/**
 * Created by PhpStorm.
 * User: mighty
 * Date: 2/21/2018
 * Time: 2:40 PM
 */

namespace App\Repositories\TaskType;


use App\Models\Stage;
use App\Models\Task;
use App\Models\TaskType;

class TaskTypeRepository implements TaskTypeRepositoryInterface
{

    /**
     * @param Task $task
     * @param TaskType $taskType
     * @return Task
     */
    public function tagTask(Task $task, TaskType $taskType)
    {
        $task->type = $taskType->id;
        $task->save();
        return $task;
    }

    /**
     * @param TaskType $taskType
     * @param Stage|null $stage
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTasks(TaskType $taskType, Stage $stage = null)
    {
        if(!$stage){
            return $taskType->tasks()->get();
        }
        return $taskType->tasks()
            ->where('stage_id', $stage->id)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return TaskType::all();
    }

    /**
     * @param $id
     * @return TaskType
     */
    public function getById($id)
    {
       return TaskType::find($id);
    }

    /**
     * @param array $attributes
     * @return TaskType
     */
    public function create(array $attributes)
    {
        return TaskType::create($attributes);
    }

    /**
     * @param TaskType $taskType
     * @param array $attributes
     * @return bool
     */
    public function update(TaskType $taskType, array $attributes)
    {
        return $taskType->update($attributes);
    }

    /**
     * @param TaskType $taskType
     * @return bool
     */
    public function delete(TaskType $taskType)
    {
        try{
            $taskType->delete();
        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * @param TaskType $taskType
     * @return TaskType
     */
    public function setDefault(TaskType $taskType)
    {
        $default = $this->getDefault();
        if($default){
            $default->default = false;
            $default->save();
        }
        $taskType->default = true;
        $taskType->save();
        return $taskType;
    }

    /**
     * @return TaskType
     */
    public function getDefault()
    {
        return TaskType::where('default', true)
            ->first();
    }

    /**
     * @param TaskType $taskType
     * @return bool
     */
    public function isDefault(TaskType $taskType)
    {
        return $taskType->default;
    }
}