<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\Roles;
use App\Models\User;

use Modules\Core\Entities\File as DFile;
use Modules\Core\Entities\Validasi;


class ValidasiController extends Controller
{
    protected $title = 'Validasi';

    /**
     * Siapkan konstruktor controller
     * 
     * @param Model
     */
    public function __construct(Dfile $kategori, Validasi $data, Roles $user) 
    {
        $this->kategori   = $kategori;
        $this->data     = $data;
        $this->user     = $user;

        $segment = request()->segment(4);
        $this->toIndex = $segment ? route('epanel.file.validasi.index', [$segment]) : '#';
        $this->prefix = 'epanel.file.validasi';
        $this->view = 'core::file.validasi';

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
    public function index(Request $request,$kategori)
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
     * Tampilkan halaman untuk menambah data
     * 
     * @param  $kategori
     * @return Illuminate\View\View
     */
    public function create($id) 
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

        return $request;    
 
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

    }

    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Back [Tampilkan halaman yang sama]
     */
    public function update(Request $request, $kategori, $id) 
    {

    }

    /**
     * Lakukan penghapusan data yang tidak diinginkan
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return String
     */
    public function destroy(Request $request, $kategori, $id) 
    {

    }

    /**
     * Datatable API
     * 
     * @param  $data
     * @return Datatable
     */
}
