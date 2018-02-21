<?php
/**
 * Created by PhpStorm.
 * User: mighty
 * Date: 2/21/2018
 * Time: 11:35 AM
 */

namespace App\Repositories\Stage;

use App\Models\Stage;
use App\Models\Task;

interface StageRepositoryInterface
{
    public function getAll();

    public function getById($id);

    public function create(array $attributes);

    public function update(Stage $stage, array $attributes);

    public function delete(Stage $stage);

    public function getTasks(Stage $stage);

    public function moveTask(Task $task, Stage $_old, Stage $_new);

    public function markAsCompleted(Stage $stage);

    public function markAsUncompleted(Stage $stage);

    public function getCompletedTasks(Stage $stage);

    public function getUncompletedTasks(Stage $stage);

    public function getCompletedPercentage(Stage $stage);

    public function getUncompletedPercentage(Stage $stage);

    public function getDefaultStage();

    public function setDefaultStage(Stage $stage);

    public function isDefault(Stage $stage);
}