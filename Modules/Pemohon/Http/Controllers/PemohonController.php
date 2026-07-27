<?php

namespace Modules\Pemohon\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pemohon\Entities\Pemohon;
use Ramsey\Uuid\Uuid;

class PemohonController extends Controller
{

    protected $title = 'Pengguna JARSIPLUS';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct(Pemohon $data)
    {
        $this->data = $data;

        $this->toIndex = route('epanel.pemohon.index');
        $this->prefix = 'epanel.pemohon';
        $this->view = 'pemohon::pemohon';

        $this->tCreate = "$this->title created successfully!";
        $this->tUpdate = "$this->title changed successfully!";
        $this->tDelete = "Some $this->title deleted successfully!";

        view()->share([
            'title' => $this->title,
            'view' => $this->view,
            'prefix' => $this->prefix
        ]);
    }


    public function index(Request $request)
    {
        $data = $this->data::orderBy('id', 'desc')->get();
        if ($request->has('datatable')):
            return $this->datatable($data);
        endif;
        return view("$this->view.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view("$this->view.create");
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $input = request()->all();
        $input['slug'] = str_slug($request->nama);

        if ($request->hasFile('file')):
            $input['file'] = $this->upload($request->file('file'));
        endif;

        if ($request->hasFile('foto')):
            $input['foto'] = $this->upload($request->file('foto'), str_slug($request->judul));
        endif;

        // return $input;

        $this->data->create($input);

        notify()->flash($this->tCreate, 'success');
        return redirect($this->toIndex);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, $id)
    {
        if ($request->has('pilihan')):
            foreach ($request->pilihan as $temp):
                $each = $this->data->uuid($temp)->firstOrFail();
                $each->delete();
            endforeach;
            notify()->flash($this->tDelete, 'success');
            return redirect()->back();
        endif;
        $satu = $this->data->uuid($id)->first();
        $satu->delete();
        return 'success';
    }

    public function upload($file)
    {
        $tmpFilePath = 'app/public/sikerja/pemohon';
        $tmpFileDate = date('Y-m') . '/' . date('d') . '/';
        $tmpFileName = uniqid();
        $tmpFileExt = $file->getClientOriginalExtension();

        makeImgDirectory($tmpFilePath . $tmpFileDate);
        $nama_file = $tmpFilePath . $tmpFileDate . $tmpFileName;

        $file->move(storage_path() . '/' . $tmpFilePath . $tmpFileDate, $tmpFileName . '.' . $tmpFileExt);

        return "storage/sikerja/pemohon{$tmpFileDate}{$tmpFileName}.{$tmpFileExt}";
    }



    public function datatable($data)
    {
        return datatables()->of($data)
            ->editColumn('pilihan', function ($data) {
                $return = '<span>';
                $return .= '<div class="checkbox checkbox-only">';
                $return .= '<input type="checkbox" id="pilihan[' . $data->id . ']" name="pilihan[]" value="' . $data->uuid . '">';
                $return .= '<label for="pilihan[' . $data->id . ']"></label>';
                $return .= '</div>';
                $return .= '</span>';
                return $return;
            })
            ->editColumn('nama', function ($data) {
                return '<strong>' . $data->name . '</strong>';
            })
            ->editColumn('instansi', function ($data) {
                $return = '<span>' . ($data->unit_kerja ?? '-') . '</span>';
                if ($data->jabatan) {
                    $return .= '<br><small class="text-muted">' . $data->jabatan . '</small>';
                }
                return $return;
            })
            ->editColumn('action', function ($data) {
                return '<a href="' . route("$this->prefix.edit", $data->uuid) . '" class="btn btn-white btn-xs" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Pengguna">
                <span class="iconify" data-icon="uil:edit"></span>
                </a>';
            })
            ->escapeColumns(['*'])->toJson();
    }
}
