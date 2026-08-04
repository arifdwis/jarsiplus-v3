<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\File;
use Modules\Formulir\Entities\Permohonan;

class FileController extends Controller
{

   protected $title = 'File Kerjasama';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct(File $data, Permohonan $kategori) 
    {
        $this->data = $data;
        $this->kategori = $kategori;
        $this->view = 'core::file';
        $this->prefix = 'epanel.permohonan.file';
        $this->toIndex = route('epanel.permohonan.file.index', request()->segment(4));
        

        $this->toIndexPenawaran = route('epanel.penawaran.index');
        $this->viewPenawaran = 'core::file.penawaran';

        $this->toIndexKesepakatan = route('epanel.kesepakatan.index');
        $this->viewKesepakatan = 'core::file.kesepakatan';

        $this->toIndexPerjanjian = route('epanel.perjanjian.index');
        $this->viewPerjanjian = 'core::file.perjanjian';

        $this->tCreate = "$this->title created successfully!";
        $this->tUpdate = "$this->title changed successfully!";
        $this->tDelete = "Some $this->title deleted successfully!";

        view()->share([
            'title' => $this->title, 
            'view' => $this->view,
            'prefix' => $this->prefix
        ]);
    }


    // public function index(Request $request)
    // {
    //     $data = $this->data::orderBy('id','desc')->get();
    //     if($request->has('datatable')):
    //         return $this->datatable($data);
    //     endif;
    //     return view("$this->view.index", compact('data'));
    // }

    public function index(Request $request, $kategori)
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        $data = $kategori->permohonan()->latest()->get();

        if($request->has('datatable')):
            return $this->datatable($data, $kategori);
        endif;
        
        return view("$this->view.index", compact('data', 'kategori'));
    }


    public function penawaran(Request $request)
    {
        $data = $this->data::where('label','penawaran')->get();
        if($request->has('datatable')):
            return $this->datatable($data);
        endif;
        return view("$this->viewPenawaran.index", compact('data'));
    }

    public function kesepakatan(Request $request)
    {
        $data = $this->data::where('label','kesepakatan')->get();
        if($request->has('datatable')):
            return $this->datatable($data);
        endif;
        return view("$this->viewPenawaran.index", compact('data'));
    }

    public function perjanjian(Request $request)
    {
        $data = $this->data::where('label','perjanjian')->get();
        if($request->has('datatable')):
            return $this->datatable($data);
        endif;
        return view("$this->viewPenawaran.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($kategori) 
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();

        return view("$this->view.create", compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $input = request()->all(); 
        // return $request;

        $input['slug'] = str_slug($request->permohonan->kode.$request->label);

        if($request->hasFile('file')):
            $input['file'] = $this->upload($request->file('file'));
        endif;

        return $input;

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
        if($request->has('pilihan')):
            foreach($request->pilihan as $temp):
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
        $tmpFilePath = 'app/public/sikerja/permohonan/file';
        $tmpFileDate =  date('Y-m') .'/'.date('d').'/';
        $tmpFileName = uniqid();
        $tmpFileExt = $file->getClientOriginalExtension();

        makeImgDirectory($tmpFilePath . $tmpFileDate);
        $nama_file = $tmpFilePath . $tmpFileDate . $tmpFileName;

        $file->move(storage_path() . '/' . $tmpFilePath . $tmpFileDate, $tmpFileName . '.' . $tmpFileExt);

        return "storage/sikerja/permohonan/file/{$tmpFileDate}{$tmpFileName}.{$tmpFileExt}";
    }



    public function datatable($data) 
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
            $return  = $data->label;
            return $return;
        })
        ->editColumn('deskripsi', function($data) {
            $return  = $data->deskripsi;
            return $return;
        })
        ->editColumn('status', function($data) {
            $return  = $data->status;
            return $return;
        })
        ->editColumn('action', function($data) {
            return '<a href="'.route("$this->prefix.edit", $data->uuid).'" class="link link-secondary">
            <span class="iconify" data-icon="uil:edit"></span> <span class="">Edit</span>
            </a>';

            return $return;
        })
        ->escapeColumns(['*'])->toJson();
    }
}
