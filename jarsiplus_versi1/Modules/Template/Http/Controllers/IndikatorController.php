<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;

use Modules\Formulir\Entities\Permohonan;
use Modules\Formulir\Entities\Indikator;
use Modules\Formulir\Entities\Parameter;
use Modules\Formulir\Entities\Penilaian;
use Modules\Core\Entities\Histori;


class IndikatorController extends Controller
{
    protected $title = 'indikator';

    public function __construct(Permohonan $parent, Penilaian $data, Indikator $indikator, Parameter $parameter) 
    {
        $this->parent    = $parent;
        $this->indikator = $indikator;
        $this->parameter = $parameter;
        $this->data      = $data;

        $this->module   = strtolower('Template');
        $this->entiti   = strtolower('Indikator');
        $this->view     = $this->module.'::permohonan.'.$this->entiti;
        $this->prefix   = 'permohonan.indikator';

        $this->tCreate  = "$this->title created successfully!";

        view()->share([
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    public function index(Request $request, $parent)
    {
        $parent = $this->parent->uuid($parent)->firstOrFail();
        // return $parent;
        $data = $parent->inovasis()->latest()->get();
        return view("$this->view.index", compact('parent', 'data'));
    }

    public function update(Request $request, $parent, $id)
    {   
        if (role_me() == 4 && pendaftaran_inovasi_ditutup()) {
            notify()->flash(pendaftaran_inovasi_pesan_tutup(), 'warning');
            return redirect()->route('permohonan.indikator.index', $parent);
        }

        // return $id;
        $parent = $this->parent->uuid($parent)->firstOrFail();
        $edit = $parent->inovasis()->where('id', $id)->first();
        // return $edit;
        
        $input = $request->all();
        // return $input;

        $edit->update($input);

        return redirect()->route('permohonan.indikator.index', $parent->uuid)->with('success', 'Indikator berhasil diperbarui!');
    }

}
