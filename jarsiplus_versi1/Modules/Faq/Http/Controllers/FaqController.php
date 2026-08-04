<?php

namespace Modules\Faq\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Faq\Entities\Faq;

class FaqController extends Controller
{

 protected $title = 'FaQ';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct(Faq $data) 
    {
        $this->data = $data;

        $this->toIndex = route('epanel.faq.index');
        $this->prefix = 'epanel.faq';
        $this->view = 'faq::faq';

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
       // $input['slug'] = str_slug($request->id);
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
    public function edit($id)
    {
        $edit = $this->data->uuid($id)->firstOrFail();
        // return $edit;
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

        $input = $request->all();
        // $input['slug'] = str_slug($request->id);
        // return $input;
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
            $return  = Str::limit($data->label, 50);
            return $return;
        })
         ->editColumn('jawaban', function($data) {
            $return  = Str::limit($data->jawaban, 50);
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
