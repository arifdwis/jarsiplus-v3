<?php

namespace Novay\Nue;

use Illuminate\Support\Facades\Route;

abstract class Extension
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    public $assets = '';

    /**
     * @var string
     */
    public $views = '';

    /**
     * @var string
     */
    public $migrations = '';

    /**
     * Extension instance.
     *
     * @var Extension
     */
    protected static $instance;

    /**
     * Returns the singleton instance.
     *
     * @return self
     */
    protected static function getInstance()
    {
        $class = get_called_class();

        if (!isset(self::$instance[$class]) || !self::$instance[$class] instanceof $class) {
            self::$instance[$class] = new static();
        }

        return static::$instance[$class];
    }

    /**
     * Bootstrap this extension.
     */
    public static function boot()
    {
        $extension = static::getInstance();

        Nue::extend($extension->name, get_called_class());

        if ($extension->disabled()) {
            return false;
        }

        return true;
    }

    /**
     * Get the path of assets files.
     *
     * @return string
     */
    public function assets()
    {
        return $this->assets;
    }

    /**
     * Get the path of view files.
     *
     * @return string
     */
    public function views()
    {
        return $this->views;
    }

    /**
     * Get the path of migration files.
     *
     * @return string
     */
    public function migrations()
    {
        return $this->migrations;
    }

    /**
     * Whether the extension is enabled.
     *
     * @return bool
     */
    public function enabled()
    {
        return static::config('enable') !== false;
    }

    /**
     * Whether the extension is disabled.
     *
     * @return bool
     */
    public function disabled()
    {
        return !$this->enabled();
    }

    /**
     * Get config set in config/nue.php.
     *
     * @param string $key
     * @param null   $default
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function config($key = null, $default = null)
    {
        $name = array_search(get_called_class(), Nue::$extensions);

        if (is_null($key)) {
            $key = sprintf('nue.extensions.%s', strtolower($name));
        } else {
            $key = sprintf('nue.extensions.%s.%s', strtolower($name), $key);
        }

        return config($key, $default);
    }

    /**
     * Set routes for this extension.
     *
     * @param $callback
     */
    public static function routes($callback)
    {
        $attributes = array_merge([
            'prefix'     => config('nue.route.prefix'),
            'middleware' => config('nue.route.middleware'),
        ], static::config('route', []));

        Route::group($attributes, $callback);
    }

    /**
     * Create a item in Nue left side menu.
     *
     * @param string $title
     * @param string $uri
     * @param string $icon
     * @param int    $parentId
     * @param array  $children
     *
     * @throws \Exception
     *
     * @return Model
     */
    public static function createMenu($title, $uri, $icon = 'fa-bars', $parentId = 0, array $children = [])
    {
        $menuModel = config('nue.database.menu_model');

        $lastOrder = $menuModel::max('order');
        /**
         * @var Model
         */
        $menu = $menuModel::create([
            'parent_id' => $parentId,
            'order'     => $lastOrder + 1,
            'title'     => $title,
            'icon'      => $icon,
            'uri'       => $uri,
        ]);
        if (!empty($children)) {
            $extension = static::getInstance();
            foreach ($children as $child) {
                if ($extension->validateMenu($child)) {
                    $subTitle = Arr::get($child, 'title');
                    $subUri = Arr::get($child, 'path');
                    $subIcon = Arr::get($child, 'icon');
                    $subChildren = Arr::get($child, 'children', []);
                    static::createMenu($subTitle, $subUri, $subIcon, $menu->getKey(), $subChildren);
                }
            }
        }

        return $menu;
    }

    /**
     * Create a permission for this extension.
     *
     * @param       $name
     * @param       $slug
     * @param       $path
     * @param array $methods
     */
    public static function createPermission($name, $slug, $path, $methods = [])
    {
        $permissionModel = config('nue.database.permissions_model');

        $permissionModel::create([
            'name'        => $name,
            'slug'        => $slug,
            'http_path'   => '/'.trim($path, '/'),
            'http_method' => $methods,
        ]);
    }
}