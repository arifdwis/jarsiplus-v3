<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Nue;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);

        $this->module   = strtolower('Template');
        $this->entiti   = strtolower('Roles');
        $this->view     = $this->module.'::'.$this->entiti;
        view()->share([
            'view' => $this->view, 
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role_id = Nue::user()->roles->first()->id;

        $envs = [
            ['name' => 'PHP version',       'value' => 'PHP/'.PHP_VERSION],
            ['name' => 'Laravel version',   'value' => app()->version() . ' <b>(Nue v'.\Novay\Nue\Nue::VERSION.')</b>'],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => 'Uname',             'value' => php_uname()],
            ['name' => 'Server',            'value' => Arr::get($_SERVER, 'SERVER_SOFTWARE')],

            ['name' => 'Cache driver',      'value' => config('cache.default')],
            ['name' => 'Session driver',    'value' => config('session.driver')],
            ['name' => 'Queue driver',      'value' => config('queue.default')],

            ['name' => 'Timezone',          'value' => config('app.timezone')],
            ['name' => 'Locale',            'value' => config('app.locale')],
            ['name' => 'Env',               'value' => config('app.env')],
            ['name' => 'URL',               'value' => config('app.url')],
        ];

        $json = file_get_contents(base_path('composer.json'));
        $dependencies = json_decode($json, true)['require'];

        $extensions = [
            'backup' => [
                'name' => 'nue-extensions/backup',
                'link' => 'https://github.com/nue-extensions/backup',
                'icon' => 'copy',
            ],
            'log-viewer' => [
                'name' => 'nue-extensions/log-viewer',
                'link' => 'https://github.com/nue-extensions/log-viewer',
                'icon' => 'database',
            ],
            'api-tester' => [
                'name' => 'nue-extensions/api-tester',
                'link' => 'https://github.com/nue-extensions/api-tester',
                'icon' => 'sliders',
            ],
        ];

        switch ($role_id) {
          
          case 1:
            return view('dashboard', compact('envs', 'dependencies', 'extensions'));
          break;
          
          case 3:
            return view('template::index',compact('role_id'));
          break;

          case 4:
            return view('template::index',compact('role_id'));
          break;
         
          default:
            return view('dashboard', compact('envs', 'dependencies', 'extensions'));
        }
        
    }
}
