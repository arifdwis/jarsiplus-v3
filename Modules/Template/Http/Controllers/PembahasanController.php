<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Formulir\Entities\Penilaian;
use Modules\Formulir\Entities\DataDukung as Dfile;
use Modules\Core\Entities\Pembahasan;

class PembahasanController extends Controller
{
    protected $title = 'Pembahasan';
    protected $parent;
    protected $dfile;
    protected $data;
    protected $module;
    protected $entiti;
    protected $view;
    protected $prefix;
    protected $tCreate;

    public function __construct(Penilaian $parent, Dfile $dfile, Pembahasan $data) 
    {
        $this->parent   = $parent;
        $this->dfile    = $dfile;
        $this->data     = $data;
    
        $this->module   = strtolower('Template');
        $this->entiti   = strtolower('Pembahasan');
        $this->view     = $this->module.'::permohonan.'.$this->entiti;
        $this->prefix   = 'indikator.data';

        $this->tCreate = "$this->title created successfully!";

        view()->share([
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    /**
     * Menampilkan detail lengkap
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Illuminate\View\View
     */
    public function index(Request $request,$parent,$uuid)
    {
        $parent = $this->parent->uuid($parent)->firstOrFail();
        // return $parent; 
        $data   = $this->dfile->uuid($uuid)->firstOrFail();
        // return $data;
        if($request->ajax())
        {
            return view("$this->view.chat",compact('parent','data'))->render();
        }

        return view("$this->view.index",compact('parent','data'));
    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param  Illuminate\Http\Request
     * @return mixed
     */

    public function store(Request $request, $parent, $uuid) 
    {
        $input = $request->all();
        $parentModel = $this->parent->uuid($parent)->firstOrFail();
        $data = $this->dfile->uuid($uuid)->firstOrFail();

        $input['id_permohonan'] = $data->id_permohonan;
        $input['id_file'] = $data->id;
        $input['id_operator'] = me() ? me()->id : auth()->id();
        
        if (empty($input['id_histori']) && $data->histori) {
            $input['id_histori'] = $data->histori->id;
        }

        $this->data::create($input);

        if ($request->ajax() || $request->wantsJson()) {
            $parent = $parentModel;
            return view("$this->view.chat", compact('parent', 'data'))->render();
        }

        return redirect()->back();
    }
    
}