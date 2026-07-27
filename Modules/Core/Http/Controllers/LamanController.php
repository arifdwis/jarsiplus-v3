<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\Laman;

class LamanController extends Controller
{

 protected $title = 'Laman';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct(Laman $data) 
    {
        $this->data = $data;

        $this->toIndex = route('epanel.laman.index');
        $this->prefix = 'epanel.laman';
        $this->view = 'core::laman';

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
        $data = $this->data::orderBy('id','desc')->get();
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
       $input['slug'] = str_slug($request->label);
       $input['status'] = '0';
       $input['id_operator'] = optional(auth()->user())->id;

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
        return view('kategori::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Request $request,$id)
    {
        $edit = $this->data->uuid($id)->firstOrFail();

        if($request->has('status')):
            $edit->update(['status' => $edit->status == 0 ? 1 : 0]);
            notify()->flash(__('status laman dirubah'), 'success');
            return redirect()->back();
        endif;

        return view("$this->view.edit", compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $edit = $this->data->uuid($id)->firstOrFail();

        $input = request()->all(); 
        $input['slug'] = str_slug($request->label);
        $input['id_operator'] = optional(auth()->user())->id;

        $edit->update($input);

        notify()->flash($this->tUpdate, 'success');
        return redirect($this->toIndex);
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
