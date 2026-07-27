<?php

namespace Collective\Html;

use Illuminate\Contracts\View\Factory;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Session\Store;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Arr;

class FormBuilder
{
    use Macroable;

    protected $html;
    protected $url;
    protected $view;
    protected $csrfToken;
    protected $session;
    protected $model;
    protected $labels = [];

    public function __construct(HtmlBuilder $html, UrlGenerator $url = null, Factory $view = null, $csrfToken = null)
    {
        $this->html = $html;
        $this->url = $url;
        $this->view = $view;
        $this->csrfToken = $csrfToken;
    }

    public function open(array $options = [])
    {
        $method = Arr::get($options, 'method', 'post');
        $attributes['method'] = $this->getMethod($method);
        $attributes['action'] = $this->getAction($options);
        $attributes['accept-charset'] = 'UTF-8';

        $append = $this->getAppendage($method);

        if (isset($options['files']) && $options['files']) {
            $options['enctype'] = 'multipart/form-data';
        }

        $attributes = array_merge($attributes, Arr::except($options, ['method', 'url', 'route', 'action', 'files']));

        return '<form' . $this->html->attributes($attributes) . '>' . $append;
    }

    public function model($model, array $options = [])
    {
        $this->model = $model;

        return $this->open($options);
    }

    public function close()
    {
        $this->model = null;

        return '</form>';
    }

    public function token()
    {
        $token = $this->csrfToken ?: ($this->session ? $this->session->token() : null);

        return $token ? '<input type="hidden" name="_token" value="' . $token . '">' : '';
    }

    protected function getMethod($method)
    {
        $method = strtoupper($method);

        return $method !== 'GET' ? 'POST' : 'GET';
    }

    protected function getAppendage($method)
    {
        $method = strtoupper($method);
        $append = $this->token();

        if (in_array($method, ['PUT', 'PATCH', 'DELETE'])) {
            $append .= '<input type="hidden" name="_method" value="' . $method . '">';
        }

        return $append;
    }

    protected function getAction(array $options)
    {
        if (isset($options['url'])) {
            return $this->url ? $this->url->to($options['url']) : $options['url'];
        }

        if (isset($options['route'])) {
            if (is_array($options['route'])) {
                $routeName = Arr::get($options['route'], 0);
                $params = array_slice($options['route'], 1);
                return $this->url ? $this->url->route($routeName, $params) : $routeName;
            }
            return $this->url ? $this->url->route($options['route']) : $options['route'];
        }

        if (isset($options['action'])) {
            return $this->url ? $this->url->action($options['action']) : $options['action'];
        }

        return $this->url ? $this->url->current() : '';
    }

    public function label($name, $value = null, $options = [], $escape_html = true)
    {
        $this->labels[] = $name;
        $options = $this->html->attributes($options);
        $value = $value ?: ucfirst($name);

        if ($escape_html) {
            $value = $this->html->entities($value);
        }

        return '<label for="' . $name . '"' . $options . '>' . $value . '</label>';
    }

    public function input($type, $name, $value = null, $options = [])
    {
        if (! isset($options['name'])) {
            $options['name'] = $name;
        }

        $id = $this->getIdAttribute($name, $options);
        if (! is_null($id)) {
            $options['id'] = $id;
        }

        $value = $this->getValueAttribute($name, $value);

        if (! is_null($value)) {
            $options['value'] = $value;
        }

        $options['type'] = $type;

        return '<input' . $this->html->attributes($options) . '>';
    }

    public function text($name, $value = null, $options = [])
    {
        return $this->input('text', $name, $value, $options);
    }

    public function password($name, $options = [])
    {
        return $this->input('password', $name, '', $options);
    }

    public function hidden($name, $value = null, $options = [])
    {
        return $this->input('hidden', $name, $value, $options);
    }

    public function email($name, $value = null, $options = [])
    {
        return $this->input('email', $name, $value, $options);
    }

    public function file($name, $options = [])
    {
        return $this->input('file', $name, null, $options);
    }

    public function textarea($name, $value = null, $options = [])
    {
        if (! isset($options['name'])) {
            $options['name'] = $name;
        }

        $id = $this->getIdAttribute($name, $options);
        if (! is_null($id)) {
            $options['id'] = $id;
        }

        $value = (string) $this->getValueAttribute($name, $value);

        return '<textarea' . $this->html->attributes(Arr::except($options, ['size'])) . '>' . $this->html->entities($value) . '</textarea>';
    }

    public function select($name, $list = [], $selected = null, array $selectAttributes = [], array $optionsAttributes = [], array $optgroupsAttributes = [])
    {
        $selected = $this->getValueAttribute($name, $selected);
        $selectAttributes['name'] = $name;
        $id = $this->getIdAttribute($name, $selectAttributes);
        if (! is_null($id)) {
            $selectAttributes['id'] = $id;
        }

        $html = [];
        foreach ($list as $value => $display) {
            $html[] = $this->getSelectOption($display, $value, $selected, $optionsAttributes);
        }

        return '<select' . $this->html->attributes($selectAttributes) . '>' . implode('', $html) . '</select>';
    }

    protected function getSelectOption($display, $value, $selected, array $attributes = [])
    {
        $selected = $this->getSelectedValue($value, $selected);
        $options = array_merge(['value' => $value, 'selected' => $selected], $attributes);

        if (! $selected) {
            unset($options['selected']);
        }

        return '<option' . $this->html->attributes($options) . '>' . $this->html->entities($display) . '</option>';
    }

    protected function getSelectedValue($value, $selected)
    {
        if (is_array($selected)) {
            return in_array($value, $selected) || in_array((string) $value, $selected, true);
        }

        return (string) $value === (string) $selected;
    }

    public function checkbox($name, $value = 1, $checked = null, $options = [])
    {
        return $this->check('checkbox', $name, $value, $checked, $options);
    }

    public function radio($name, $value = null, $checked = null, $options = [])
    {
        if (is_null($value)) {
            $value = $name;
        }

        return $this->check('radio', $name, $value, $checked, $options);
    }

    protected function check($type, $name, $value, $checked, $options)
    {
        if (is_null($checked)) {
            $checked = $this->getValueAttribute($name) == $value;
        }

        if ($checked) {
            $options['checked'] = 'checked';
        }

        return $this->input($type, $name, $value, $options);
    }

    public function submit($value = null, $options = [])
    {
        return $this->input('submit', null, $value, $options);
    }

    public function button($value = null, $options = [])
    {
        if (! isset($options['type'])) {
            $options['type'] = 'button';
        }

        return '<button' . $this->html->attributes($options) . '>' . $value . '</button>';
    }

    public function getValueAttribute($name, $value = null)
    {
        if (is_null($name)) {
            return $value;
        }

        if (! is_null($value)) {
            return $value;
        }

        if (isset($this->model)) {
            return data_get($this->model, $name);
        }

        return null;
    }

    public function getIdAttribute($name, $attributes)
    {
        if (array_key_exists('id', $attributes)) {
            return $attributes['id'];
        }

        if (in_array($name, $this->labels)) {
            return $name;
        }

        return null;
    }

    public function setSessionStore(Store $session)
    {
        $this->session = $session;

        return $this;
    }
}
