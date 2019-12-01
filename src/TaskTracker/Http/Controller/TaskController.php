<?php

namespace TaskTracker\Http\Controller;

use TaskTracker\Interfaces\TaskRepository;

class TaskController extends BaseController
{
    /**
     * @var TaskRepository
     */
    private $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all tasks
     *
     * @return void
     */
    public function index()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $task = $this->repository->getTasks($data);

        return $this->sendResponse($task);
    }

    /**
     * Get a task
     *
     * @param  int $id
     *
     * @return void
     */
    public function get(int $id)
    {
        $task = $this->repository->getTask($id);

        return $this->sendResponse($task);
    }

    /**
     * Get a task
     *
     * @return void
     */
    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $task = $this->repository->createTask($data);

        return $this->sendResponse($task);
    }

    /**
     * Edit a task
     *
     * @return void
     */
    public function edit($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $task = $this->repository->editTask($id, $data);

        return $this->sendResponse($task);
    }

    /**
     * Delete a task
     *
     * @param  int $id
     *
     * @return void
     */
    public function delete(int $id)
    {
        $task = $this->repository->deleteTask($id);

        return $this->sendResponse($task);
    }
}
