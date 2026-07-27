<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Template\Entities\MapsKelurahan;

class MapsController extends Controller
{
     /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Maps';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MapsKelurahan $data) 
    {
        $this->data = $data;
        $this->module = strtolower('Template');
        $this->entiti = strtolower('Maps');
        $this->view   = $this->module.'::'.$this->entiti;
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
        if($request->has('geojson'))
        {
            $data =  $this->data::with('kelurahan','kecamatan')->get();
            return $data;
        }
        return view("$this->view.index");
    }
   
}
