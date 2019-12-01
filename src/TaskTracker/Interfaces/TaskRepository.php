<?php
declare(strict_types=1);

namespace TaskTracker\Interfaces;

interface TaskRepository
{
    /**
     * @param array $data
     *
     * @return Tasks[]
     */
    public function getTasks(?array $data);

    /**
     * @param int $id
     * @return Task|null
     */
    public function getTask(int $id);

    /**
     * @param array $data
     * @return Task
     */
    public function createTask(array $data);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteTask(int $id);

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function editTask(int $id, array $data);

    public function deleteAll();
}
