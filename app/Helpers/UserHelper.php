<?php

namespace App\Helpers;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserHelper
{
    /**
     * Handle get user role
     *
     * @return string
     */

    public static function getUserRole(): string
    {
        return auth()->user()->roles->pluck('name')[0];
    }
    /**
     * Handle get user role
     *
     * @return string
     */

    public static function getUserId(): string
    {
        return auth()->user()->id;
    }

    /**
     * Handle get username
     *
     * @return string
     */

    public static function getUserName(): string
    {
        return auth()->user()->name;
    }

    /**
     * Handle get email
     *
     * @return string
     */

    public static function getUserEmail(): string
    {
        return auth()->user()->email;
    }
    /**
     * Handle get email
     *
     * @return string|null
     */

    public static function getUserPhoto(): string|null
    {
        return auth()->user()->photo;
    }

}
