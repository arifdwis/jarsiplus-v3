<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


use Modules\Core\Entities\File as DFile;
use Modules\Core\Entities\Pembahasan;
use Modules\Core\Entities\Histori;


class PembahasanController extends Controller
{
    protected $title = 'Pembahasan';

    /**
     * Siapkan konstruktor controller
     * 
     * @param Model
     */
    public function __construct(Pembahasan $data, DFile $kategori, Histori $histori) 
    {
        $this->data = $data;
        $this->kategori = $kategori;
        $this->histori = $histori;

        $segment = request()->segment(4);
        $this->toIndex = $segment ? route('epanel.file.pembahasan.index', [$segment]) : '#';
        $this->prefix = 'epanel.file.pembahasan';
        $this->view = 'core::file.pembahasan';

        $this->tCreate = "Data $this->title berhasil ditambah!";
        $this->tUpdate = "Data $this->title berhasil diubah!";
        $this->tDelete = "Beberapa data $this->title berhasil dihapus sekaligus!";

        view()->share([
            'title' => $this->title, 
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }
    
    /**
     * Tampilkan halaman utama modul yang dipilih
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\View\View
     */
    public function index(Request $request, $kategori) 
    {


        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        // return $kategori;
        $data = $kategori->file_one()->latest()->get();
        // return $data;
        
        return view("$this->view.index", compact('data', 'kategori'));
    }

    /**
     * Tampilkan halaman untuk menambah data
     * 
     * @param  $kategori
     * @return Illuminate\View\View
     */
    public function create($id) 
    {
     $kategori = $this->kategori::whereUuid($id)->firstOrFail();
     return view("$this->view.create",compact('kategori'));
 }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param  Illuminate\Http\Request
     * @return mixed
     */
    public function store(Request $request, $id) 
    {
        $kategori = $this->kategori::whereUuid($id)->firstOrFail();
        $data   = $this->kategori->uuid($id)->firstOrFail();
        // return $request;
        $input = request()->all(); 
        // return $request;

        $input['slug'] = $request->komentar;
        $input['id_file'] = $kategori->id;
        $input['id_permohonan'] = $kategori->permohonan->id;
        $input['id_histori'] = $data->histori->id;
        $input['id_operator'] = optional(auth()->user())->id;
        $input['status_komentar'] = '0';

        // return $input;

        $this->data->create($input);

        notify()->flash($this->tCreate, 'success');
        return redirect(route("epanel.file.pembahasan.index", $kategori->uuid));
    }

    /**
     * Menampilkan detail lengkap
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Illuminate\View\View
     */
    public function show($kategori, $id)
    {
        return abort(404);
    }

    /**
     * Tampilkan halaman perubahan data
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Illuminate\View\View
     */
    public function edit($kategori, $id) 
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        $edit = $this->data->uuid($id)->firstOrFail();

        return view("$this->view.edit", compact('edit', 'kategori'));
    }

    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Back [Tampilkan halaman yang sama]
     */
    public function update(Request $request, $kategori, $id) 
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        $edit = $this->data->uuid($id)->firstOrFail();

        $input = $request->all();
        
        if($request->hasFile('file')):
            $input['file'] = $this->upload($request->file('file'), uuid());
        endif;

        $edit->update($input);
        
        notify()->flash($this->tUpdate, 'success');
        return redirect(route("epanel.file"));
    }

    /**
     * Lakukan penghapusan data yang tidak diinginkan
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return String
     */
    public function destroy(Request $request, $kategori, $id) 
    {
        if($request->has('pilihan')):
            foreach($request->pilihan as $temp):
                $each = $this->data->uuid($temp)->firstOrFail();
                deleteFile($each->file);
                $each->delete();
            endforeach;
            
            notify()->flash($this->tDelete, 'success');
            return redirect()->back();
        endif;
    }

    /**
     * Datatable API
     * 
     * @param  $data
     * @return Datatable
     */
    public function datatable($data, $kategori) 
    {
        return datatables()->of($data)
        ->editColumn('pilihan', function($data) {
            $return  = '<span>';
            $return .= '    <div class="checkbox checkbox-only">';
            $return .= '        <input type="checkbox" id="pilihan['.$data->id.']" name="pilihan[]" value="'.$data->uuid.'">';
            $return .= '        <label for="pilihan['.$data->id.']"></label>';
            $return .= '    </div>';
            $return .= '</span>';
            return $return;
        })
        ->editColumn('label', function($data) {
            $return  = $data->operator->name.'<br>'.'<label class="badge bg-primary">'.'User : '.$data->operator->name.'</label>'.'<br>'.'<label class="badge bg-success">'.'Roles : '.$data->operator->roles->first()->name;
            return $return;
        })
        ->editColumn('deskripsi', function($data) {
            $return  = '<a href="'.asset("$value->file").'" data-lity">';
            return $return;
        })
        ->editColumn('file', function($data) {
            $return  = $data->file;
            return $return;
        })
        ->editColumn('tanggal', function($data) {
            $return  =  tgl_indo($data->created_at).'<br>'.'<label class="badge bg-primary">'.\Carbon\Carbon::createFromTimeStamp(strtotime($data->created_at))->diffForHumans().'</label>';
            return $return;
        })
        ->editColumn('action', function($data) use ($kategori) {
            return '<a href="'.route("$this->prefix.edit", [$kategori->id , $data->uuid]).'" class="link link-secondary">
            <span class="iconify" data-icon="uil:edit"></span> <span class="">Edit</span>
            </a>';

            return $return;
        })
        ->escapeColumns(['*'])->toJson();
    }
}
