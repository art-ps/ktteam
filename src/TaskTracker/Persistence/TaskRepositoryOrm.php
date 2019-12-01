<?php
declare(strict_types=1);

namespace TaskTracker\Persistence;

use Illuminate\Support\Collection;
use TaskTracker\Model\Task;
use TaskTracker\Interfaces\TaskRepository;

class TaskRepositoryOrm implements TaskRepository
{
    /**
     * Get tasks
     *
     * @return Collection|null
     */
    public function getTasks($data): ?Collection
    {
        $filter = [['id', '>', 0]];

        if ($data) {
            $filter = [];
            foreach ($data as $key => $value) {
                $filter[$key] = $value;
            }
        }

        return Task::where($filter)->get();
    }

    /**
     * Get a task
     *
     * @param  int $id
     *
     * @return Task|null
     */
    public function getTask(int $id): ?Task
    {
        return Task::with('user')->find($id);
    }

    /**
     * Create a task
     *
     * @param  array $data
     *
     * @return Task|null
     */
    public function createTask(array $data): ?Task
    {
        return Task::create($data);
    }

    /**
     * Edit a task
     *
     * @param  array $data
     *
     * @return Task|null
     */
    public function editTask(int $id, array $data): bool
    {
        $task = Task::find($id);

        foreach ($data as $key => $value) {
            $task->$key = $value;
        }

        return $task->save();
    }

    /**
     * Delete a task
     *
     * @param  int $id
     *
     * @return bool
     */
    public function deleteTask(int $id): bool
    {
        return (bool)Task::destroy($id);
    }
    
    /**
     * Delete all tasks
     *
     * @return bool
     */
    public function deleteAll(): bool
    {
        return (bool)Task::getQuery()->delete();
    }
}
