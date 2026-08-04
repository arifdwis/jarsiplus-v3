<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Template\Entities\MapsKecamatan;

class KecamatanController extends Controller
{
     /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Kecamatan';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MapsKecamatan $data) 
    {
        $this->data = $data;
        $this->module = strtolower('Template');
        $this->entiti = strtolower('Kecamatan');
        $this->view = $this->module.'::'.$this->entiti;
        
        view()->share([
            'title' => $this->title, 
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function show(Request $request,$id)
    {
        $parent =  $this->data::where('kecamatan_id',$id)
                    ->select('uuid','kecamatan_id','nama','area')
                    ->first();

        if($request->has('news'))
        {
            $data = (array) apiSmr('v2/berita/kecamatan','GET',['kecamatan_id'=>$id,'paginate'=>8]);
            return $data;
        }

        return view("$this->view.show",compact('parent'));
    }

     /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function maintenace()
    {
        return view('template::index');
    }

   
}
