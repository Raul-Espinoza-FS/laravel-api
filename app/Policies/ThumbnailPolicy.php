<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThumbnailPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->can('create_article');
    }
}
