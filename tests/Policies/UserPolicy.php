<?php

namespace Elnooronline\LaravelConcerns\Tests\Policies;

use Elnooronline\LaravelConcerns\Tests\Models\User;

class UserPolicy
{
    /**
     * Determine if the given user can be updated by the authenticated user.
     *
     * @param  \Elnooronline\LaravelConcerns\Tests\Models\User  $user
     * @param  \Elnooronline\LaravelConcerns\Tests\Models\User  $model
     * @return bool
     */
    public function update(?User $user, User $model)
    {
        return true;
        return $user->id === $model->id;
    }
}