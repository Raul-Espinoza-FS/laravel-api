<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->can('create_article');
    }

    public function edit(User $user, Post $post)
    {
        return $user->can('edit_article') && ($user->id == $post->user_id);
    }

    public function delete(User $user, Post $post) 
    {
        return $user->can('delete_article') && ($user->id == $post->user_id);
    }
}
