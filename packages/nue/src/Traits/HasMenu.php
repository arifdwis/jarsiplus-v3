<?php

namespace Novay\Nue\Traits;

trait HasMenu
{
	/**
     * @var array
     */
    protected $menu = [];

    /**
     * Left sider-bar menu.
     *
     * @return array
     */
    public function menu()
    {
        if (!empty($this->menu)) {
            return $this->menu;
        }

        $menuClass = config('nue.database.menu_model');

        /** @var Menu $menuModel */
        $menuModel = new $menuClass();

        return $this->menu = $menuModel->toTree();
    }
}