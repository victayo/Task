<?php
/**
 * Created by PhpStorm.
 * User: mighty
 * Date: 2/20/2018
 * Time: 4:18 PM
 */

namespace App\Repositories\Task;


use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{

    public function getAll()
    {
        return Task::get();
    }

    public function getById($id)
    {
        return Task::find($id);
    }

    public function create(array $attributes)
    {
        return Task::create($attributes);
    }

    public function update($id, array $attributes)
    {
        $task = $this->getById($id);
        return $task->update($attributes);
    }

    public function delete($id)
    {
        $this->getById($id)->delete();
    }

    public function getCompleted()
    {
        return Task::whereNotNull('completed')->get();
    }

    public function getUncompleted()
    {
        return Task::whereNull('completed')->get();
    }

    public function getTasksStartedOn($date)
    {
        return Task::whereDate('start_date', $date)->get();
    }

    public function getTasksStartedBefore($date)
    {
        return Task::whereDate('start_date', '<', $date)->get();
    }

    public function getTasksStartedAfter($date)
    {
        return Task::whereDate('start_date', '>', $date)->get();
    }

    public function getTasksStartedBetween($startDate, $endDate)
    {
        return Task::whereDate('start_date', '>', $startDate)
            ->whereDate('start_date', '<', $endDate)
            ->get();
//        return Task::whereBetween('start_date', [$startDate, $endDate])
//            ->get();
    }

    public function getTasksEndingOn($date)
    {
        return Task::whereDate('end_date', $date)->get();
    }

    public function getTasksEndingBefore($date)
    {
        return Task::whereDate('end_date', '<', $date)->get();
    }

    public function getTasksEndingAfter($date)
    {
        return Task::whereDate('end_date', '>', $date)->get();
    }

    public function getTasksEndingBetween($startDate, $endDate)
    {
        return Task::whereDate('end_date', '>', $startDate)
            ->whereDate('end_date', '<', $endDate)
            ->get();
    }
}