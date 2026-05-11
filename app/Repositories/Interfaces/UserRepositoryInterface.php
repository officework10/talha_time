<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function find(int $id);

    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Create or update a user.
     *
     * @param array $data
     * @return User
     */
    public function updateOrCreate(array $data);

    // Add other user-related methods as needed
}
