<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\Event;

class EventController extends Controller
{
    protected $title = 'Event & Lomba Inovasi';

    public function __construct(Event $data) 
    {
        $this->data = $data;

        $this->toIndex = route('epanel.event.index');
        $this->prefix = 'epanel.event';
        $this->view = 'core::event';

        $this->tCreate = "$this->title berhasil ditambahkan!";
        $this->tUpdate = "$this->title berhasil diperbarui!";
        $this->tDelete = "$this->title berhasil dihapus!";

        view()->share([
            'title' => $this->title, 
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    public function index(Request $request) 
    {
        $data = $this->data->latest()->get();

        if($request->has('datatable')):
            return $this->datatable($data);
        endif;

        return view("$this->view.index", compact('data'));
    }

    public function create() 
    {
        return view("$this->view.create");
    }

    public function store(Request $request) 
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $input = $request->all();
        $input['id_operator'] = optional(auth()->user())->id;

        if ($request->hasFile('banner')) {
            $input['banner'] = $this->upload($request->file('banner'), 'banner_' . uuid());
        }

        if ($request->hasFile('file_edaran')) {
            $input['file_edaran'] = $this->upload($request->file('file_edaran'), 'edaran_' . uuid());
        }

        if ($request->hasFile('file_panduan')) {
            $input['file_panduan'] = $this->upload($request->file('file_panduan'), 'panduan_' . uuid());
        }

        $this->data->create($input);

        return redirect($this->toIndex)->with('success', $this->tCreate);
    }

    public function edit($id) 
    {
        $edit = $this->data->where('uuid', $id)->orWhere('id', $id)->firstOrFail();
        return view("$this->view.edit", compact('edit'));
    }

    public function update(Request $request, $id) 
    {
        $data = $this->data->where('uuid', $id)->orWhere('id', $id)->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $input = $request->all();

        if ($request->hasFile('banner')) {
            $input['banner'] = $this->upload($request->file('banner'), 'banner_' . uuid());
        }

        if ($request->hasFile('file_edaran')) {
            $input['file_edaran'] = $this->upload($request->file('file_edaran'), 'edaran_' . uuid());
        }

        if ($request->hasFile('file_panduan')) {
            $input['file_panduan'] = $this->upload($request->file('file_panduan'), 'panduan_' . uuid());
        }

        $data->update($input);

        return redirect($this->toIndex)->with('success', $this->tUpdate);
    }

    public function destroy($id) 
    {
        if ($id == 'hapus-all') {
            $this->data->whereIn('id', request('ids', []))->delete();
        } else {
            $data = $this->data->where('uuid', $id)->orWhere('id', $id)->firstOrFail();
            $data->delete();
        }

        return redirect($this->toIndex)->with('success', $this->tDelete);
    }

    public function datatable($data) 
    {
        return datatables()->of($data)
            ->addColumn('pilihan', function($data) {
                return '<div class="form-check mb-0"><input type="checkbox" name="ids[]" value="'.$data->id.'" class="form-check-input check-id"><label class="form-check-label"></label></div>';
            })
            ->editColumn('banner', function($data) {
                if ($data->banner) {
                    $src = asset($data->banner);
                    return '<a href="'.$src.'" data-lity><img src="'.$src.'" height="30" class="rounded">';
                }
                return '-';
            })
            ->addColumn('action', function($data) {
                $updateUrl = route($this->prefix.'.update', $data->uuid ?? $data->id);
                $titleAttr = htmlspecialchars($data->title, ENT_QUOTES, 'UTF-8');
                $descAttr = htmlspecialchars($data->description ?? '', ENT_QUOTES, 'UTF-8');
                $bannerAttr = asset($data->banner ?? 'baimbai/Banner Lomba Baimbai 2026.jpeg');

                return '<button type="button" class="btn btn-xs btn-outline-secondary" onclick="openEditModal(\''.$updateUrl.'\', \''.$titleAttr.'\', \''.$descAttr.'\', \''.$bannerAttr.'\')"><i class="bi-pencil me-1"></i> Edit</button>';
            })
            ->rawColumns(['pilihan', 'banner', 'action'])
            ->make(true);
    }

    private function upload($file, $name)
    {
        $destinationPath = 'storage/sikerja/event/' . date('Y-m') . '/' . date('d');
        $extension = $file->getClientOriginalExtension();
        $fileName = $name . '.' . $extension;

        $targetDirPublic = public_path($destinationPath);
        if (!file_exists($targetDirPublic)) {
            mkdir($targetDirPublic, 0755, true);
        }

        $file->move($targetDirPublic, $fileName);

        // Auto sync to public_html if exists
        $publicHtmlPath = base_path('public_html/' . $destinationPath);
        if (file_exists(base_path('public_html'))) {
            if (!file_exists($publicHtmlPath)) {
                mkdir($publicHtmlPath, 0755, true);
            }
            copy($targetDirPublic . '/' . $fileName, $publicHtmlPath . '/' . $fileName);
        }

        $resPath = $destinationPath . '/' . $fileName;
        sync_to_s3($resPath);
        return $resPath;
    }
}
