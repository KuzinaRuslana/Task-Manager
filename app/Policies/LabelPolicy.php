<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Label;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabelPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return (bool)$user;
    }

    public function update(User $user, Label $label): bool
    {
        return (bool)$user;
    }

    public function delete(User $user, Label $label): bool
    {
        return (bool)$user;
    }
}
