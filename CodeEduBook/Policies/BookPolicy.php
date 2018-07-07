<?php

namespace CodeEduBook\Policies;

use CodeEduBook\Models\Livro;
use CodeEduUser\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    public function before($user,$ability){
        if($user->can(config('codeedubook.acl.permissions.book_manage_all'))){
            return true;
        }
    }

    /**
     * Determine whether the user can update the livro.
     *
     * @param User $user
     * @param Livro $livro
     * @return mixed
     */
    public function update(User $user, Livro $livro)
    {
        return $user->id == $livro->author_id;
    }

}
