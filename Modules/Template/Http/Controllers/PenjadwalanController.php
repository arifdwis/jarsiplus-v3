<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Formulir\Entities\Permohonan;
use Modules\Core\Entities\File as Dfile;
use Modules\Core\Entities\Penjadwalan;
use Modules\Core\Entities\Histori;


class PenjadwalanController extends Controller
{
    protected $title = 'Penjadwalan';

    public function __construct(Permohonan $data) 
    {
        $this->data     = $data;

        $this->module   = strtolower('Template');
        $this->entiti   = strtolower('Penjadwalan');
        $this->view     = $this->module.'::permohonan.'.$this->entiti;
        $this->prefix = 'persetujuan';

        $this->tCreate = "$this->title created successfully!";

        view()->share([
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    public function index($uuid) 
    {
        $data = $this->data->uuid($uuid)->firstOrFail();
        return view("$this->view.index", compact('data'));
    }
    

    public function update(Request $request, $id)
    {

        $data = $this->data->uuid($id)->firstOrFail();
        $input = $request->all();

        // return $input;
        $edit->update($input);    

        notify()->flash($this->tUpdate, 'success');
        return redirect($this->toIndex);

    }
    
}