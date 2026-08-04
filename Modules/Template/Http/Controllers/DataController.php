<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Formulir\Entities\Penilaian;
use Modules\Formulir\Entities\DataDukung;
use Modules\Core\Entities\Validasi;
use App\Observers\FileObserver;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    protected $title = 'Data Dukung';
    protected $parent;
    protected $data;
    protected $validasi;
    protected $module;
    protected $entiti;
    protected $view;
    protected $prefix;
    protected $tCreate;
    protected $tUpdate;

    public function __construct(Penilaian $parent, DataDukung $data, Validasi $validasi)
    {
        $this->parent = $parent;
        $this->data = $data;
        $this->validasi = $validasi;

        $this->module = strtolower('Template');
        $this->entiti = strtolower('Indikator.File');
        $this->view = $this->module . '::permohonan.' . $this->entiti;
        $this->prefix = 'indikator.data';

        $this->tCreate = "Data dukung berhasil ditambahkan!";
        $this->tUpdate = "Data dukung berhasil diperbarui!";

        view()->share([
            'view' => $this->view,
            'prefix' => $this->prefix
        ]);
    }


    public function index(Request $request, $parent)
    {
        $parent = $this->parent->uuid($parent)->firstOrFail();
        $data = $parent->files()->latest()->get();
        $permohonan = $parent->inovasis;

        return view("$this->view.index", compact('parent', 'data', 'permohonan'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request, $parent)
    {
        if (role_me() == 4 && pendaftaran_inovasi_ditutup()) {
            notify()->flash(pendaftaran_inovasi_pesan_tutup(), 'warning');
            return redirect()->route("$this->prefix.index", $parent);
        }

        $parent = $this->parent->uuid($parent)->firstOrFail();
        return view("$this->view.create", compact('parent'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, $uuid)
    {
        if (role_me() == 4 && pendaftaran_inovasi_ditutup()) {
            notify()->flash(pendaftaran_inovasi_pesan_tutup(), 'warning');
            return redirect()->route("$this->prefix.index", $uuid);
        }

        $parent = $this->parent->uuid($uuid)->firstOrFail();

        // Validasi server-side
        $request->validate([
            'label' => 'required',
            'nomor_surat' => 'required',
            'file' => 'nullable|max:10240',
        ], [
            'file.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        $input = $request->all();
        $input['id_operator'] = me()->id;
        $input['inovasi_penilaian_id'] = $parent->id;
        $input['status'] = 0; // Berkas baru belum disetujui

        if ($request->hasFile('file')) {
            $input['file'] = $this->upload($request->file('file'));
        }

        $this->data::create($input);
        notify()->flash("Data dukung berhasil ditambahkan!", 'success');
        return redirect(route("$this->prefix.index", $uuid));
    }

    public function update(Request $request, $parent, $id)
    {
        if (role_me() == 4 && pendaftaran_inovasi_ditutup()) {
            notify()->flash(pendaftaran_inovasi_pesan_tutup(), 'warning');
            return redirect()->route("$this->prefix.index", $parent);
        }

        $parent = $this->parent->uuid($parent)->firstOrFail();
        $data = $this->data->uuid($id)->firstOrFail();

        $request->validate([
            'label' => 'required',
            'file' => 'nullable|max:10240',
        ], [
            'file.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        $input = $request->all();
        $input['id_operator'] = me()->id;

        if ($request->hasFile('file')) {
            $input['file'] = $this->upload($request->file('file'));
        }

        $data->update($input);

        notify()->flash("Pembaruan data dukung berhasil disimpan!", 'success');
        return redirect()->back();
    }

    public function validate(Request $request, $parent, $id)
    {
        $parent = $this->parent->uuid($parent)->firstOrFail();
        $data = $this->data->uuid($id)->firstOrFail();
        $input = $request->all();
        $input['id_permohonan'] = $parent->id;
        
        $statusVal = 0;
        if (isset($input['validate']) && ($input['validate'] == '1' || $input['validate'] === 1)) {
            $statusVal = 1;
        }

        $input['status'] = $statusVal;

        // Simpan / update ke tabel validasi
        $this->validasi->updateOrCreate(['id_file' => $data->id, 'id_operator' => me()->id], $input);

        // PERBAIKAN: Update status langsung pada record data_dukung agar kartu & badge langsung ter-update!
        $data->status = $statusVal;
        $data->save();

        $penilaian = Penilaian::where('id', $parent->id)->first();
        if ($penilaian && isset($parent->parameters)) {
            $penilaian->bobot = $parent->parameters->bobot;
            $penilaian->label_parameter = $parent->parameters->label;
            $penilaian->save();
        }

        $msg = ($statusVal == 1) ? 'Berkas data dukung berhasil disetujui!' : 'Persetujuan berkas data dukung telah dibatalkan.';
        notify()->flash($msg, 'success');
        return redirect()->back();
    }

    public function destroy(Request $request, $parent, $id)
    {
        if (role_me() == 4 && pendaftaran_inovasi_ditutup()) {
            notify()->flash(pendaftaran_inovasi_pesan_tutup(), 'warning');
            return redirect()->back();
        }

        $data = $this->data->uuid($id)->firstOrFail();
        $data->delete();

        notify()->flash("Data dukung berhasil dihapus!", 'success');
        return redirect()->back();
    }

    public function upload($file)
    {
        $path = 'jarsiplus/inovasi/file/';
        $tmpFilePath = 'app/public/' . $path;

        $targetPath = storage_path($tmpFilePath);
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $name = time() . '.' . $file->getClientOriginalExtension();
        $file->move($targetPath, $name);
        return 'storage/' . $path . $name;
    }
}
