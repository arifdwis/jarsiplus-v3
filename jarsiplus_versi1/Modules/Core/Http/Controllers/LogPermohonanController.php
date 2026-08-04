<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Formulir\Entities\Permohonan;
use Modules\Core\Entities\Histori;


class LogPermohonanController extends Controller
{

   protected $title = 'Pengajuan Kerjasama';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct(Histori $data) 
    {
        $this->data = $data;
        $this->toIndex = route('epanel.logpermohonan.index');
        $this->prefix = 'epanel.logpermohonan';
        $this->view = 'core::logpermohonan';

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
        $data = $this->data::orderBy('id','asc')->get();
        if($request->has('datatable')):
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

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {


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
        
    }

    public function datatable($data) 
    {
        return datatables()->of($data)
            ->editColumn('pilihan', function($data) {
                return '<div class="form-check mb-0">
                    <input type="checkbox" class="form-check-input pilihan" id="pilihan['.$data->id.']" name="pilihan[]" value="'.$data->id.'">
                        <label class="form-check-label" for="pilihan['.$data->id.']"></label>
                    </div>';
            })
            ->editColumn('user', function($data) {
                return $data->operator->name;
            })
            ->editColumn('deskripsi', function($data) {
                return '<label class="badge bg-primary">'.$data->deskripsi.'</label>';
            })
            ->escapeColumns(['*'])->toJson();
    }
}
