<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Formulir\Entities\Permohonan;
use Modules\Core\Entities\File as Data;
use Modules\Core\Entities\Validasi;
use App\Observers\HistoriObserver;


class BerkasController extends Controller
{
    protected $title = 'Berkas';

    public function __construct(Permohonan $parent, Data $data, Validasi $validasi) 
    {
        $this->parent   = $parent;
        $this->data    = $data;
        $this->validasi    = $validasi;
    
        $this->module   = strtolower('Template');
        $this->entiti   = strtolower('Data');
        $this->view     = $this->module.'::permohonan.'.$this->entiti;
        $this->prefix   = 'permohonan.'.$this->entiti;

        $this->tCreate = "$this->title created successfully!";
        $this->tUpdate = "$this->title udpated successfully!";

        view()->share([
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    public function index(Request $request, $uuid)
    {
        $parent = $this->parent::where('uuid',$uuid)->firstOrFail();
        return view("$this->view.index",compact('parent'));
    }

    public function create(Request $request, $uuid)
    {
        $parent = $this->parent::where('uuid',$uuid)->firstOrFail();
        return view("$this->view.create",compact('parent'));
    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param  Illuminate\Http\Request
     * @return mixed
     */
    public function store(Request $request, $uuid) 
    {

        $parent = $this->parent->uuid($uuid)->firstOrFail();
        $input  = request()->all(); 
        $slug   = str_slug($parent->kode.'-'.$request->label);
        $input['slug'] = $slug;
        $input['id_permohonan'] = $parent->id;

        if($request->hasFile('file')):
            $input['file'] = $this->upload($request->file('file'));
        endif;

        $this->data::updateOrCreate(['slug'=>$slug],$input);
        notify()->flash($this->tCreate, 'success');
        return redirect(route("$this->prefix.index", $uuid));
    }

    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Back [Tampilkan halaman yang sama]
     */
    public function update(Request $request, $parent, $id) 
    {
        $parent = $this->parent->uuid($parent)->firstOrFail();
        $data = $this->data->uuid($id)->firstOrFail();
        $input = $request->all();
        
        $input['id_operator'] = me()->id;
        if($request->hasFile('file')):
            $input['file'] = $this->upload($request->file('file'));
        endif;

        $data->update($input);
        
        notify()->flash($this->tUpdate, 'success');
        return redirect()->back();
    }


    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Back [Tampilkan halaman yang sama]
     */
    public function validate(Request $request, $parent, $id) 
    {
        $parent = $this->parent->uuid($parent)->firstOrFail();
        $data = $this->data->uuid($id)->firstOrFail();
        $input = $request->all();
        $input['id_permohonan'] = $parent->id;
        $input['status'] = 0;
        
        if(isset($input['validate'])) {
            $input['status'] = 1;
        }

        $this->validasi->updateOrCreate(['id_file'=>$data->id, 'id_operator'=> me()->id],$input);
        
        notify()->flash($this->tUpdate, 'success');
        return redirect()->back();
    }

    /**
     * Function for Upload File
     * 
     * @param  $file, $filename
     * @return URI
     */
    public function upload($file) 
    {
        $path = 'sikerja/permohonan/file/';
        $tmpFilePath = 'app/public/'.$path;
        $tmpFileDate =  date('Y-m') .'/'.date('d').'/';
        $tmpFileName = uniqid();
        $tmpFileExt = $file->getClientOriginalExtension();
        $file->move(storage_path().'/'.$tmpFilePath.'/'.$tmpFileDate, $tmpFileName . '.' . $tmpFileExt);
        return "storage/{$path}{$tmpFileDate}/{$tmpFileName}.{$tmpFileExt}";
    }
    
}