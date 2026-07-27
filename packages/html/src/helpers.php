<?php

if (! function_exists('link_to')) {
    function link_to($url, $title = null, $attributes = [], $secure = null, $escapeTitle = true)
    {
        return app('html')->link($url, $title, $attributes, $secure, $escapeTitle);
    }
}
