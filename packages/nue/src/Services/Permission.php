<?php

namespace Novay\Nue\Services;

use Novay\Nue\Facades\Nue;

class Permission
{
    /**
     * Check permission.
     *
     * @param $permission
     *
     * @return true
     */
    public static function check($permission)
    {
        if (static::isAdministrator()) {
            return true;
        }

        if (is_array($permission)) {
            collect($permission)->each(function ($permission) {
                call_user_func([self::class, 'check'], $permission);
            });

            return;
        }

        if (Nue::user()->cannot($permission)) {
            static::error();
        }
    }

    /**
     * Roles allowed to access.
     *
     * @param $roles
     *
     * @return true
     */
    public static function allow($roles)
    {
        if (static::isAdministrator()) {
            return true;
        }

        if (!Nue::user()->inRoles($roles)) {
            static::error();
        }
    }

    /**
     * Don't check permission.
     *
     * @return bool
     */
    public static function free()
    {
        return true;
    }

    /**
     * Roles denied to access.
     *
     * @param $roles
     *
     * @return true
     */
    public static function deny($roles)
    {
        if (static::isAdministrator()) {
            return true;
        }

        if (Nue::user()->inRoles($roles)) {
            static::error();
        }
    }

    /**
     * Send error response page.
     */
    public static function error()
    {
        return response()->json(['Deny']);

        // $response = response(Nue::content()->withError(trans('nue.deny')));

        if (request()->ajax()) {
            abort(403, trans('nue.deny'));
        }
    }

    /**
     * If current user is administrator.
     *
     * @return mixed
     */
    public static function isAdministrator()
    {
        return Nue::user()->isRole('administrator');
    }
}
