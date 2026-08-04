<?php

namespace Modules\Template\Http\Controllers\Settings;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pemohon\Entities\Corporate;

class CorporateController extends Controller
{
    protected $title = 'Data Instansi';
    protected $data;
    protected $module;
    protected $entiti;
    protected $view;
    protected $prefix;
    protected $tCreate;
    protected $tUpdate;

    public function __construct(Corporate $data) 
    {
        $this->data = $data;
        
        $this->module   = strtolower('Template');
        $this->entiti   = strtolower('Corporate');
        $this->view     = $this->module.'::settings.'.$this->entiti;
        $this->prefix   = 'settings.'.$this->entiti;

        $this->tCreate = "$this->title created successfully!";
        $this->tUpdate = "$this->title updated successfully!";

        view()->share([
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    public function index()
    {
        $user = me();
        $data = $this->data::where('id_operator', $user->id)->first();
        
        if(!$data):
            $input['id_operator'] = $user->id;
            $data = $this->data::create($input);
        endif;

        $kotas = class_exists('\Modules\Wilayah\Entities\Kota') 
            ? \Modules\Wilayah\Entities\Kota::orderBy('name', 'asc')->get() 
            : collect();

        return view("$this->view.index", compact('data', 'kotas'));
    }

    public function update(Request $request, $uuid = null)
    {
        $user = me();
        $edit = $this->data::where('id_operator', $user->id)->first();
        if (!$edit && $uuid && $uuid !== 'default') {
            $edit = $this->data::where('uuid', $uuid)->first();
        }
        if (!$edit) {
            $edit = $this->data::create(['id_operator' => $user->id]);
        }

        $input = $request->all();

        if (!empty($input['kota_id']) && str_contains($input['kota_id'], ';')) {
            $exp = explode(";", $input['kota_id']);
            $input['kota'] = $exp[1];
            $input['kota_id'] = $exp[0];
        }

        $edit->update($input);

        if (function_exists('notify')) {
            notify()->flash($this->tUpdate, 'success');
        }

        return redirect()->back();
    }
}