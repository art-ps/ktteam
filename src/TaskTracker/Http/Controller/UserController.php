<?php

namespace TaskTracker\Http\Controller;

use TaskTracker\Interfaces\UserRepository;

class UserController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
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
        $task = $this->repository->getUsers();

        return $this->sendResponse($task);
    }
}
