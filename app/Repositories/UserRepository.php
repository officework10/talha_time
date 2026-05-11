<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function find(int $id)
    {
        return User::find($id);
    }

    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return User::all();
    }

    /**
     * Create or update a user.
     *
     * @param array $data
     * @return User
     */
    public function updateOrCreate(array $data)
    {
        return User::updateOrCreate(
            ['email' => $data['email']],
            $data
        );
    }
}
