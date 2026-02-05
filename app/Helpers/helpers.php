<?php

if (! function_exists('currentUser')) {
    /**
     * Get the currently authenticated user.
     *
     * @return \App\Models\User|null
     */
    function currentUser()
    {
        return auth()->user();
    }
}

if (! function_exists('currentUserId')) {
    /**
     * Get the ID of the currently authenticated user.
     *
     * @return int|null
     */
    function currentUserId()
    {
        return auth()->id();
    }
}
