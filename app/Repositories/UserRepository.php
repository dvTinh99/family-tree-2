<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends RepositoryBase
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Get users by role (if applicable)
     */
    public function getByRole(string $role): Collection
    {
        return $this->model->where('role', $role)->get();
    }

    /**
     * Update user profile
     */
    public function updateProfile(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }
}
