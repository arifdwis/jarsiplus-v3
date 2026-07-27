<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;

use Modules\Formulir\Entities\Permohonan;
use Modules\Formulir\Entities\Penilaian;
use Modules\Formulir\Entities\DataDukung;
use Modules\Core\Entities\Histori;
use Modules\Core\Entities\Validasi;
use App\Observers\FileObserver;


class DataController extends Controller
{
    protected $title = 'data';

    public function __construct(Penilaian $parent, DataDukung $data, Validasi $validasi)
    {
        $this->parent = $parent;
        $this->data = $data;
        $this->validasi = $validasi;

        $this->module = strtolower('Template');
        $this->entiti = strtolower('Indikator.File');
        $this->view = $this->module . '::permohonan.' . $this->entiti;
        $this->prefix = 'indikator.data';

        $this->tCreate = "$this->title created successfully!";
        $this->tUpdate = "$this->title udpated successfully!";

        view()->share([
            'view' => $this->view,
            'prefix' => $this->prefix
        ]);
    }


    public function index(Request $request, $parent)
    {
        $parent = $this->parent->uuid($parent)->firstOrFail();
        // return $parent;
        $data = $parent->files()->latest()->get();
        $permohonan = $parent->inovasis;

        return view("$this->view.index", compact('parent', 'data', 'permohonan'));
    }



    public function create(Request $request, $uuid)
    {
        if (role_me() == 4 && pendaftaran_inovasi_ditutup()) {
            notify()->flash(pendaftaran_inovasi_pesan_tutup(), 'warning');
            return redirect()->route("$this->prefix.index", $uuid);
        }

        $parent = $this->parent::where('uuid', $uuid)->firstOrFail();
        $permohonan = $parent->inovasis;
        return view("$this->view.create", compact('parent', 'permohonan'));
    }

    public function store(Request $request, $uuid)
    {
        if (role_me() == 4 && pendaftaran_inovasi_ditutup()) {
            notify()->flash(pendaftaran_inovasi_pesan_tutup(), 'warning');
            return redirect()->route("$this->prefix.index", $uuid);
        }

        // Validasi server-side
        $request->validate([
            'label' => 'required',
            'url' => 'required_without:file',
            'file' => 'required_without:url|max:10240',
        ], [
            'url.required_without' => 'URL/Link harus diisi jika File Berkas kosong.',
            'file.required_without' => 'File Berkas harus diisi jika URL/Link kosong.',
            'file.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        $parent = $this->parent->uuid($uuid)->firstOrFail();
        $input = $request->all();
        $slug = str_slug($request->label) . '-' . time();
        $input['slug'] = $slug;
        $input['id_permohonan'] = $parent->inovasi_id;
        $input['inovasi_penilaian_id'] = $parent->id;
        $input['status'] = 0; // Berkas baru selalu belum tervalidasi


        // Jika ada file yang diupload, proses uploadnya
        if ($request->hasFile('file')) {
            $input['file'] = $this->upload($request->file('file'));
        }

        $this->data::create($input);
        notify()->flash($this->tCreate, 'success');
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

        // Validasi server-side
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

        // FileObserver akan otomatis membuat histori saat update
        $data->update($input);

        notify()->flash($this->tUpdate, 'success');
        return redirect()->back();
    }


    public function validate(Request $request, $parent, $id)
    {
        $parent = $this->parent->uuid($parent)->firstOrFail();
        $data = $this->data->uuid($id)->firstOrFail();
        $input = $request->all();
        $input['id_permohonan'] = $parent->id;
        $input['status'] = 0;

        if (isset($input['validate'])) {
            $input['status'] = 1;
        }
        //  return $input;
        $this->validasi->updateOrCreate(['id_file' => $data->id, 'id_operator' => me()->id], $input);

        $penilaian = Penilaian::where('id', $parent->id)->first();
        if ($penilaian) {
            $penilaian->bobot = $parent->parameters->bobot;
            $penilaian->label_parameter = $parent->parameters->label;
            $penilaian->save();
        }

        notify()->flash($this->tUpdate, 'success');
        return redirect()->back();
    }

    public function upload($file)
    {
        $path = 'jarsiplus/inovasi/file/';
        $tmpFilePath = 'app/public/' . $path;
        $tmpFileDate = date('Y-m') . '/' . date('d') . '/';
        $tmpFileName = uniqid();
        $tmpFileExt = $file->getClientOriginalExtension();
        $file->move(storage_path() . '/' . $tmpFilePath . '/' . $tmpFileDate, $tmpFileName . '.' . $tmpFileExt);
        return "storage/{$path}{$tmpFileDate}/{$tmpFileName}.{$tmpFileExt}";
    }


}
