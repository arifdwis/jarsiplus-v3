<?php

namespace Modules\Formulir\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Formulir\Entities\Indikator;
use Modules\Formulir\Entities\Parameter;
use Ramsey\Uuid\Uuid;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ParameterController extends Controller
{

    protected $title = 'Parameter Indikator Inovasi';
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct(Indikator $kategori, Parameter $data) 
    {
        $this->data = $data;
        $this->kategori = $kategori;

        $this->toIndex = route('epanel.indikator.parameter.index', request()->segment(4));
        $this->prefix = 'epanel.indikator.parameter';
        $this->view = 'formulir::indikator.parameter';

        $this->tCreate = "$this->title created successfully!";
        $this->tUpdate = "$this->title changed successfully!";
        $this->tDelete = "Some $this->title deleted successfully!";

        view()->share([
            'title' => $this->title, 
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }


    public function index(Request $request, $kategori) 
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        $data = $kategori->parameter()->latest()->get();

        if($request->has('datatable')):
            return $this->datatable($data, $kategori);
        endif;
        
        return view("$this->view.index", compact('data', 'kategori'));
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
    public function store(Request $request, $kategori)
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        // return $kategori;
        $this->validate($request, [
            'label' => 'required',
            'bobot' => 'required'
        ]);

        $input = $request->all();
        $input['indikator_id'] = $kategori->id;
        $input['slug'] = str_slug($request->label);

        $this->data->create($input);

        notify()->flash($this->tCreate, 'success');
        return redirect()->route("$this->prefix.index", ['indikator' => $kategori->uuid]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('kategori::show');
    }


    public function edit($kategori, $id)
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        $edit = $kategori->parameter()->uuid($id)->firstOrFail();

        return view("$this->view.edit", compact('kategori', 'edit'));
    }


    public function update(Request $request, $kategori, $id)
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        $edit = $kategori->parameter()->uuid($id)->firstOrFail();

        $this->validate($request, [
            'label' => 'required',
            'bobot' => 'required'
        ]);

        $input = $request->all();
        $input['slug'] = str_slug($request->label);

        $edit->update($input);

        notify()->flash($this->tUpdate, 'success');
        return redirect()->route("$this->prefix.index", ['indikator' => $kategori->uuid]);
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

    public function datatable($data, $kategori)
    {
        return datatables()->of($data)
        ->editColumn('pilihan', function ($data) {
            $return  = '<span>';
            $return .= '    <div class="checkbox checkbox-only">';
            $return .= '        <input type="checkbox" id="pilihan['.$data->id.']" name="pilihan[]" value="'.$data->uuid.'">';
            $return .= '        <label for="pilihan['.$data->id.']"></label>';
            $return .= '    </div>';
            $return .= '</span>';
            return $return;
        })
        ->editColumn('label', function ($data) {
            $return  = $data->label;
            return $return;
        })
        ->editColumn('slug', function ($data) {
            $return  = $data->deskripsi;
            return $return;
        })
        ->editColumn('action', function ($data) use ($kategori) {
            return '<a href="'.route("$this->prefix.edit", [$kategori->uuid, $data->uuid]).'" class="link link-secondary">
            <span class="iconify" data-icon="uil:edit"></span> <span class="">Edit</span>
            </a>';
        })
        ->escapeColumns(['*'])->toJson();
    }

}
