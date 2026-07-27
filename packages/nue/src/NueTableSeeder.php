<?php

namespace Novay\Nue;

use Illuminate\Database\Seeder;

class NueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create a user.
        $users = config('nue.database.users_model');
        $user = new $users();
        $user->truncate();
        $user->create([
            'email' => 'novay@btekno.id',
            'password' => bcrypt('adminsss'),
            'name'     => 'Noviyanto Rahmadi',
        ]);

        // create a role.
        $roles = config('nue.database.roles_model');
        $role = new $roles();
        $role->truncate();
        $role->create([
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);

        // add role to user.
        $user->first()->roles()->save($role->first());

        //create a permission
        $permissions = config('nue.database.permissions_model');
        $permission = new $permissions();
        $permission->truncate();
        $permission->insert([
            [
                'name'        => 'All Permission',
                'slug'        => '*',
                'http_method' => '',
                'http_path'   => '*',
            ],
            [
                'name'        => 'Dashboard',
                'slug'        => 'dashboard',
                'http_method' => 'GET',
                'http_path'   => '/',
            ],
            [
                'name'        => 'Login',
                'slug'        => 'nue.login',
                'http_method' => '',
                'http_path'   => "/login\r\n/logout",
            ],
            [
                'name'        => 'User setting',
                'slug'        => 'nue.profile',
                'http_method' => 'GET,PUT,DELETE',
                'http_path'   => '/profile',
            ],
            [
                'name'        => 'Nue Management',
                'slug'        => 'nue.settings',
                'http_method' => '',
                'http_path'   => "/settings/roles\r\n/settings/permission\r\n/settings/menu\r\n/settings/log-activity",
            ],
        ]);

        $role->first()->permissions()->save($permission->first());

        // add default menus.
        $menus = config('nue.database.menu_model');
        $menu = new $menus();
        $menu->truncate();
        $menu->insert([
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => 'Dashboard',
                'icon'      => 'icon-park-twotone:dashboard-one',
                'uri'       => 'home',
            ],
            [
                'parent_id' => 0,
                'order'     => 2,
                'title'     => 'Nue Settings',
                'icon'      => 'icon-park-twotone:list-success',
                'uri'       => '',
            ],
            [
                'parent_id' => 2,
                'order'     => 3,
                'title'     => 'Users',
                'icon'      => 'icon-park-twotone:peoples-two',
                'uri'       => 'settings/users',
            ],
            [
                'parent_id' => 2,
                'order'     => 4,
                'title'     => 'Roles',
                'icon'      => 'icon-park-twotone:id-card-h',
                'uri'       => 'settings/roles',
            ],
            [
                'parent_id' => 2,
                'order'     => 5,
                'title'     => 'Permission',
                'icon'      => 'icon-park-twotone:harm',
                'uri'       => 'settings/permission',
            ],
            [
                'parent_id' => 2,
                'order'     => 6,
                'title'     => 'Menu',
                'icon'      => 'icon-park-twotone:tree-diagram',
                'uri'       => 'settings/menu',
            ],
            [
                'parent_id' => 2,
                'order'     => 7,
                'title'     => 'Log Activity',
                'icon'      => 'icon-park-twotone:history-query',
                'uri'       => 'settings/log-activity',
            ],
        ]);

        // add role to menu.
        $menu->find(2)->roles()->save($role->first());
    }
}
