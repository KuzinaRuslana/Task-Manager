<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Task $task): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return (bool)$user;
    }

    public function update(User $user, Task $task): bool
    {
        return (bool)$user;
    }

    public function delete(User $user, Task $task): bool
    {
        return $task->created_by_id === $user->id;
    }
}
