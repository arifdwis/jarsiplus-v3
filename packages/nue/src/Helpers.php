<?php

use Illuminate\Support\MessageBag;

if(!function_exists('me')) {
    /**
     * Get user based on whom login.
     *
     * @return string
     */
    function me() 
    {
        return auth()->check() ? auth()->user() : null;
    }
}

if (!function_exists('notify')) {
    /**
     * Return app instance of Notify.
     * 
     * @return Novay\Notify\Notifier
     */
    function notify() {
        return app('notify');
    }
}

if (!function_exists('time_execute')) {
    /**
     * Return time execute.
     * 
     * @param string $time
     * @return string
     */
    function time_execute($time = '') {
        $micro = microtime(TRUE);
        return number_format($micro - $time, 2);
    }
}

if (!function_exists('nue_url')) {
    /**
     * Get nue url.
     *
     * @param string $path
     * @param mixed  $parameters
     * @param bool   $secure
     *
     * @return string
     */
    function nue_url($path = '', $parameters = [], $secure = null)
    {
        if (\Illuminate\Support\Facades\URL::isValidUrl($path)) {
            return $path;
        }

        $secure = $secure ?: (config('nue.https') || config('nue.secure'));

        return url(nue_base_path($path), $parameters, $secure);
    }
}

if (!function_exists('nue_base_path')) {
    /**
     * Get nue url.
     *
     * @param string $path
     *
     * @return string
     */
    function nue_base_path($path = '')
    {
        $prefix = '/'.trim(config('nue.route.prefix'), '/');

        $prefix = ($prefix == '/') ? '' : $prefix;

        $path = trim($path, '/');

        if (is_null($path) || strlen($path) == 0) {
            return $prefix ?: '/';
        }

        return $prefix.'/'.$path;
    }
}

if (!function_exists('nue_path')) {
    /**
     * Get Nue path.
     *
     * @param string $path
     *
     * @return string
     */
    function nue_path($path = '')
    {
        return ucfirst(config('nue.directory')).($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('nue_asset')) {
    /**
     * @param $path
     *
     * @return string
     */
    function nue_asset($path)
    {
        return config('nue.https') ? secure_asset($path) : asset($path);
    }
}

if (!function_exists('array_delete')) {
    /**
     * Delete from array by value.
     *
     * @param array $array
     * @param mixed $value
     */
    function array_delete(&$array, $value)
    {
        $value = \Illuminate\Support\Arr::wrap($value);

        foreach ($array as $index => $item) {
            if (in_array($item, $value)) {
                unset($array[$index]);
            }
        }
    }
}