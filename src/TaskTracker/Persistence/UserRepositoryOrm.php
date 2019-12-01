<?php
declare(strict_types=1);

namespace TaskTracker\Persistence;

use TaskTracker\Model\User;
use TaskTracker\Interfaces\UserRepository;
use Illuminate\Support\Collection;

class UserRepositoryOrm implements UserRepository
{
    /**
     * Get users
     *
     * @return Collection|null
     */
    public function getUsers(): ?Collection
    {
        return User::all();
    }

    /**
     * Create new user
     *
     * @param  array $data
     *
     * @return User
     */
    public function create(array $data = []): User
    {
        return User::create($data);
    }

    /**
     * Delete a user
     *
     * @param  int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        return (bool)User::destroy($id);
    }

    /**
     * Delete all users
     *
     * @return bool
     */
    public function deleteAll(): bool
    {
        return (bool)User::getQuery()->delete();
    }
}
