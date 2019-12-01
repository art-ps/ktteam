<?php

declare(strict_types=1);

namespace TaskTracker\Database;

use TaskTracker\Interfaces\UserRepository;
use TaskTracker\Interfaces\TaskRepository;

class Seeds
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var TaskRepository
     */
    private $taskRepository;


    public function __construct(UserRepository $userRepository, TaskRepository $taskRepository)
    {
        $this->userRepository = $userRepository;
        $this->taskRepository = $taskRepository;
    }

    /**
     * Run the seeding
     *
     * @return void
     */
    public function seed()
    {
        $this->userRepository->deleteAll();

        $firstUser = $this->userRepository->create([
            'name' => 'First User',
            'email' => 'firstemail@example.com',
            'password' => 'firstpass'
        ]);

        $secondUser =  $this->userRepository->create([
            'name' => 'Second User',
            'email' => 'secondemail@example.com',
            'password' => 'secondtpass'
        ]);

        $this->taskRepository->deleteAll();

        $firstUser->task()->create([
            'name' => 'Read a book',
            'description' => 'Find, buy and read "PHP Internals" book',
            'status' => 'planned'
        ]);

        $firstUser->task()->create([
            'name' => 'Watch a movie',
            'description' => 'Go to cinema and watch something interesting',
            'status' => 'done'
        ]);

        $secondUser->task()->create([
            'name' => 'Have a cup of coffee',
            'description' => 'Go to kitchen and drink a coffee',
            'status' => 'planned'
        ]);
    }
}
