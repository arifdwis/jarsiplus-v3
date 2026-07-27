<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Formulir\Entities\Permohonan;
use Modules\Core\Entities\Penjadwalan;

use App\Observers\PenjadwalanObserver;


class PenjadwalanController extends Controller
{
    protected $title = 'Pengajuan Persetujuan';

    /**
     * Siapkan konstruktor controller
     * 
     * @param Model
     */
    public function __construct(Penjadwalan $data, Permohonan $kategori)
    {
        $this->data = $data;
        $this->kategori = $kategori;

        $segment = request()->segment(4);
        $this->toIndex = $segment ? route('epanel.permohonan.persetujuan.index', [$segment]) : '#';
        $this->toHome = route('epanel.permohonan.index');
        $this->prefix = 'epanel.permohonan.persetujuan';
        $this->cprefix = 'epanel.persetujuan';
        $this->view = 'core::persetujuan';

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
        $data = $kategori->penjadwalan()->latest()->get();
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

    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param  Illuminate\Http\Request
     * @return mixed
     */
    public function store(Request $request, $kategori) 
    {

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
        // return $data;
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

        // return $input;

        $edit->update($input);
        
        notify()->flash($this->tUpdate, 'success');
        return redirect(route("epanel.permohonan.persetujuan.index", $kategori->uuid));

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

        ->editColumn('label', function($data) {
            $return  = $data->permohonans->label.'<br>'.'<label class="badge bg-primary">'.$data->permohonans->kode.'</label>';
            return $return;
        })
        ->editColumn('deskripsi', function($data) {
            $return  = $data->tanggal;
            return $return;
        })
        ->editColumn('kategori', function($data) {

            if ($data->kategori != 2) {
                $return  = 'Penandatangan Langsung';
            }
            else{
                $return  = 'Desk To Desk';
            }
            
            return $return;
        })
        ->editColumn('status', function($data) {

            if ($data->status == 0 && $data->kategori == 1) {
                $return  = 'Mohon Ditanggapi';
            }
            elseif ($data->status == 'Disetujui' && $data->kategori == 1) {
                $return  = 'Disetujui';
            }
            elseif ($data->status == 0 && $data->kategori == 2) {
                $return  = 'Disetujui';
            }
            else {
                $return  = 'Atur Ulang';
            }
            
            return $return;
        })
        ->editColumn('action', function($data) use ($kategori){
           if ($data->kategori != 2) {
            $return = '<a href="'.route("$this->prefix.edit", [$kategori->uuid , $data->uuid]).'" class="link link-secondary">
            <span class="iconify" data-icon="uil:edit"></span> <span class="">Kelola Jadwal</span>
            </a>';
        }
        else{

            $return  = 'Hanya Untuk Penanda Tanganan Langsung';

        }
        return $return;
    })
        ->escapeColumns(['*'])->toJson();
    }
}
