<?php
declare(strict_types=1);

namespace TaskTracker\Interfaces;

interface UserRepository
{
    /**
     * @param array $data
     * @return User
     */
    public function create(array $data);

    /**
     * @return Users[]|null
     */
    public function getUsers();
    

    /**
     * Delete all Users
     *
     * @return void
     */
    public function deleteAll();
}
