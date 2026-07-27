<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Formulir\Entities\Permohonan;
use Modules\Core\Entities\Histori;
use Modules\Pemohon\Entities\Pemohon;
use App\Observers\HistoriObserver;


class TksdController extends Controller
{
    protected $title = 'TKSD';

    public function __construct(Permohonan $data , Pemohon $pemohon , Histori $histori) 
    {
        $this->data = $data;
        $this->pemohon = $pemohon;
        $this->histori = $histori;
        
        $this->module   = strtolower('Template');
        $this->entiti   = strtolower('Tksd');
        $this->view     = $this->module.'::'.$this->entiti;
        $this->prefix   = $this->entiti;

        $this->toIndex = route("$this->prefix.index");
        $this->tCreate = "$this->title created successfully!";

        view()->share([
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    public function index()
    {
        $data = $this->data::latest()->get();
        return view("$this->view.index",compact('data'));
    }

    public function create(Request $request)
    {
        return view("$this->view.create");
    }

    public function show(Request $request, $kode)
    {
        $data = $this->data::where('kode', $kode)->firstOrFail();
        return view("$this->view.show",compact('data'));
    }

    public function detail(Request $request, $uuid)
    {
        $data = $this->data::where('uuid', $uuid)->firstOrFail();
        return view("$this->view.detail",compact('data'));
    }

    public function riwayat(Request $request, $uuid)
    {

        $histori = $this->histori::where('id_permohonan', $uuid)->get();
        // return $histori;
        return view("$this->view.riwayat",compact('histori'));
    }


    public function store(Request $request)
    { 
        $p = $request->all();
        $p['status'] = '0';
        $p['kode'] = str_random(8);
        $p['slug'] = str_slug($request->kode);

        $permohonan = $this->data::create($p);
        $pemohons =  $request['nama'];
        if($permohonan):
            foreach ($pemohons as $key=>$nama):

                $input['nama'] = $request['nama'][$key];
                $input['jabatan'] = $request['jabatan'][$key];
                $input['unit_kerja'] = $request['unit_kerja'][$key];
                $input['email_p'] = $request['email_p'][$key];
                $input['telepon_p']  = $request['telepon_p'][$key];
                $input['nip'] = $request['nip'][$key];
                $input['nik'] = $request['nik'][$key]; 
                $input['slug'] = \Str::slug($request['nama'][$key]); 
                $pemohon = $this->pemohon::create($input);
                
                if($pemohon):
                    $this->data::whereId($permohonan->id)->update(['id_pemohon_'.$key => $pemohon->id]);
                endif;
                
            endforeach;
        endif;  

        // return $permohonan;

        return redirect($this->toIndex);
    }
}