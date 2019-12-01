<?php
declare(strict_types=1);

use function DI\create;

use TaskTracker\Interfaces\TaskRepository;
use TaskTracker\Persistence\TaskRepositoryOrm;
use TaskTracker\Interfaces\UserRepository;
use TaskTracker\Persistence\UserRepositoryOrm;

return [
    TaskRepository::class => create(TaskRepositoryOrm::class),
    UserRepository::class => create(UserRepositoryOrm::class),
];
