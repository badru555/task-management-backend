<?php

namespace App\Policies;

use App\Models\TaskAttachment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskAttachmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TaskAttachment  $taskAttachment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, TaskAttachment $taskAttachment)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TaskAttachment  $taskAttachment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TaskAttachment $taskAttachment)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TaskAttachment  $taskAttachment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TaskAttachment $taskAttachment)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TaskAttachment  $taskAttachment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TaskAttachment $taskAttachment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TaskAttachment  $taskAttachment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, TaskAttachment $taskAttachment)
    {
        //
    }

    public function download(User $user, TaskAttachment $attachment)
    {
        // boleh kalau user adalah creator task, assigned user, atau admin
        return $user->id === $attachment->task->assigned_user_id || $user->is_admin;
    }
}
