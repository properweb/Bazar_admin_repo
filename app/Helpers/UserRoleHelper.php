<?php
    use Illuminate\Support\Facades\Auth;

    function getUserRole()
    {
        $user = auth()->user();

        if ($user) {
            return $user->role;
        }

        return [];
    }
