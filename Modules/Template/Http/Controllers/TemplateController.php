<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TemplateController extends Controller
{
     /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->module = strtolower('Template');
        $this->entiti = strtolower('Home');
        
        view()->share([
            'title' => $this->title, 
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        return view('template::index');
    }

    public function informasi(Request $request)
    {
        return view('template::informasi');
    }

     /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function maintenance()
    {
        return view('template::maintenance');
    }

   
}
