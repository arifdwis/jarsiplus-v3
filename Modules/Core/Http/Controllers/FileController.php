<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


use Modules\Formulir\Entities\DataDukung as DFile;
use Modules\Formulir\Entities\Permohonan;
use Modules\Formulir\Entities\Indikator;
use Modules\Formulir\Entities\Parameter;
use Modules\Core\Entities\Validasi;

use App\Models\Roles;
use App\Models\User;

use App\Observers\FileObserver;

class FileController extends Controller
{
    protected $title = 'File Kerjasama';

    /**
     * Siapkan konstruktor controller
     * 
     * @param Model
     */
    public function __construct(DFile $data, Permohonan $kategori, Validasi $validasi, Roles $user, Indikator $indikator, Parameter $parameter) 
    {
        $this->data = $data;
        $this->kategori = $kategori;
        $this->validasi = $validasi;
        $this->indikator = $indikator;
        $this->parameter = $parameter;
        $this->user = $user;

        $segment = request()->segment(4);
        $this->toIndex = $segment ? route('epanel.permohonan.file.index', [$segment]) : '#';
        $this->toHome = route('epanel.permohonan.index');
        $this->prefix = 'epanel.permohonan.file';
        $this->cprefix = 'epanel.file';
        $this->view = 'core::file';

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
        $data = $kategori->permohonans()->latest()->get();
            // return $data;
        if($request->has('datatable')):
            return $this->datatable($data, $kategori);
        endif;
        
        return view("$this->view.index", compact('data', 'kategori'));
    }

    /**
     * Tampilkan halaman untuk menambah data
     * 
     * @param  $kategori
     * @return Illuminate\View\View
     */
    public function create($kategori) 
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();

        return view("$this->view.create", compact('kategori'));
    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param  Illuminate\Http\Request
     * @return mixed
     */
    public function store(Request $request, $kategori) 
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        // return $kategori;

        $input = request()->all(); 
        // return $request;

        $input['slug'] = str_slug($kategori->kode.'-'.$request->label);
        $input['id_permohonan'] = $kategori->id;
        $input['status'] = '0';

        if($request->hasFile('file')):
            $input['file'] = $this->upload($request->file('file'));
        endif;

            // return $input;

        $this->data->create($input);

        notify()->flash($this->tCreate, 'success');
        return redirect(route("epanel.permohonan.file.index", $kategori->uuid));
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
    public function edit($kategori,$data) 
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        $edit = $this->data->uuid($data)->firstOrFail();
        $validasi = $edit->dfile()->latest()->get();
        // return $validasi;

        $tksd = $this->user->where('role_id','3')->count();
        // return $tksd;

        // return $data;
        return view("$this->view.validasi", compact('edit', 'kategori', 'tksd', 'validasi'));
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
        
        $edit['status'] = 1;

        // return $edit;

        $edit->update($input);
        
        notify()->flash($this->tUpdate, 'success');
        return redirect(route("epanel.permohonan.file.index", $kategori->uuid));
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

    public function validasi(Request $request,$kategori)
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        // return $kategori;
        $data = $kategori->dfile()->latest()->get();

        $tksd = $this->user->where('role_id','3')->count();
        // return $user;

        // return $data;
        return view("$this->view.index", compact('data', 'kategori', 'tksd'));
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
        ->editColumn('judul', function($data) {
            $return  = $data->permohonan->label.'<br>'.'<label class="badge bg-primary">'.$data->permohonan->kode.'</label>';
            return $return;
        })
        ->editColumn('label', function($data) {
            $return  = $data->label;
            return $return;
        })
        ->editColumn('status', function($data) {
            if ($data->status == 0) {
                $return  = 'Diproses';
            }
            elseif ($data->status == 1) {
                $return  = 'Disetujui';
            }
            else{
                $return  = 'Ditolak';
            }
            
            return $return;
        })
        ->editColumn('file', function($data) {

            if ($data->file != null) {
                return '<a href="'. viewImg($data->file) . '" data-lity>File Tersedia</a>';
            }

            else{
               return 'File Tidak Tesedia';
           }

           return $return;
           
       })

        ->editColumn('validasi', function($data) use ($kategori){
            return '<a href="'.route("$this->cprefix.pembahasan.index", [$data->uuid]).'" class="link link-secondary">
            <span class="iconify" data-icon="icon-park-outline:agreement"></span> <span class="">Pembahasan</span>
            </a>'.
            '<a href="'.route("$this->prefix.edit", [$kategori->uuid , $data->uuid]).'" class="link link-secondary">
            <span class="iconify" data-icon="uil:edit"></span> <span class="">Persetujuan</span>
            </a>';

            return $return;
        })
        ->escapeColumns(['*'])->toJson();
    }
}
