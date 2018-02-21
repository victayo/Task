<?php
/**
 * Created by PhpStorm.
 * User: mighty
 * Date: 2/20/2018
 * Time: 4:06 PM
 */

namespace App\Repositories\Task;


interface TaskRepositoryInterface
{
    public function getAll();

    public function getById($id);

    public function create(array $attributes);

    public function update($id, array $attributes);

    public function delete($id);

    public function getCompleted();

    public function getUncompleted();

    public function getTasksStartedOn($date);

    public function getTasksStartedBefore($date);

    public function getTasksStartedAfter($date);

    public function getTasksStartedBetween($startDate, $endDate);

    public function getTasksEndingOn($date);

    public function getTasksEndingBefore($date);

    public function getTasksEndingAfter($date);

    public function getTasksEndingBetween($startDate, $endDate);
}