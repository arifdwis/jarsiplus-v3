<?php

namespace Collective\Html;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Traits\Macroable;

class HtmlBuilder
{
    use Macroable;

    protected $url;

    public function __construct(UrlGenerator $url = null)
    {
        $this->url = $url;
    }

    public function entities($value)
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8', false);
    }

    public function decode($value)
    {
        return html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    }

    public function script($url, $attributes = [], $secure = null)
    {
        $attributes['src'] = $this->url ? $this->url->asset($url, $secure) : $url;

        return '<script' . $this->attributes($attributes) . '></script>';
    }

    public function style($url, $attributes = [], $secure = null)
    {
        $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];
        $attributes = array_merge($defaults, $attributes);
        $attributes['href'] = $this->url ? $this->url->asset($url, $secure) : $url;

        return '<link' . $this->attributes($attributes) . '>';
    }

    public function image($url, $alt = null, $attributes = [], $secure = null)
    {
        if (! is_null($alt)) {
            $attributes['alt'] = $alt;
        }

        $attributes['src'] = $this->url ? $this->url->asset($url, $secure) : $url;

        return '<img' . $this->attributes($attributes) . '>';
    }

    public function link($url, $title = null, $attributes = [], $secure = null, $escapeTitle = true)
    {
        $url = $this->url ? $this->url->to($url, [], $secure) : $url;

        if (is_null($title) || $title === '') {
            $title = $url;
        }

        if ($escapeTitle) {
            $title = $this->entities($title);
        }

        return '<a href="' . $url . '"' . $this->attributes($attributes) . '>' . $title . '</a>';
    }

    public function attributes($attributes)
    {
        $html = [];

        foreach ((array) $attributes as $key => $value) {
            $element = $this->attributeElement($key, $value);

            if (! is_null($element)) {
                $html[] = $element;
            }
        }

        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }

    protected function attributeElement($key, $value)
    {
        if (is_numeric($key)) {
            $key = $value;
        }

        if (! is_null($value)) {
            return $key . '="' . $this->entities($value) . '"';
        }

        return null;
    }
}
