<?php
/**
 * Created by PhpStorm.
 * User: mighty
 * Date: 2/21/2018
 * Time: 2:28 PM
 */

namespace App\Repositories\TaskType;


use App\Models\Stage;
use App\Models\Task;
use App\Models\TaskType;

interface TaskTypeRepositoryInterface
{
    public function getAll();

    public function getById($id);

    public function create(array $attributes);

    public function update(TaskType $taskType, array $attributes);

    public function delete(TaskType $taskType);

    public function tagTask(Task $task, TaskType $taskType);

    public function getTasks(TaskType $taskType, Stage $stage = null);

    public function setDefault(TaskType $taskType);

    public function getDefault();

    public function isDefault(TaskType $taskType);
}