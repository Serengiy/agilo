<?php

use App\Enum\UserRoleEnum;

if(!function_exists('filters')) {
    function isAdmin(): bool
    {
        return auth()->user()->role === (UserRoleEnum::ADMIN)->value;
    }
}
