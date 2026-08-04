<?php

namespace App\Http\Controllers\Nue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Roles';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->models = config('nue.database.roles_model');
        $this->data = new $this->models;
        
        $this->prefix = 'settings.roles';
        $this->view = 'nue::settings.roles';

        $this->tCreate = "$this->title created successfully!";
        $this->tUpdate = "$this->title changed successfully!";
        $this->tDelete = "Some $this->title deleted successfully!";

        view()->share([
            'title' => $this->title, 
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    /**
     * Index interface.
     *
     * @param Request $request
     *
     * @return Content
     */
    public function index(Request $request)
    {
        $data = $this->data->query();

        if($request->has('datatable')):
            return $this->datatable($data);
        endif;

        return view("{$this->view}.index", compact('data'));
    }

    /**
     * Create interface.
     *
     * @param Request $request
     *
     * @return Content
     */
    public function create(Request $request)
    {
        $permissions = config('nue.database.permissions_model')::pluck('name', 'id');

        return view("$this->view.create", compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'slug' => 'required', 
            'name' => 'required', 
        ]);

        $input = $request->all();
        
        $role = $this->data->create($input);
        $role->permissions()->sync($request->permissions);
        
        notify()->flash($this->tCreate, 'success');
        return redirect(route("$this->prefix.index"));
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Request $request
     *
     * @return Content
     */
    public function show(Request $request, $id)
    {
        abort(404);
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Request $request
     *
     * @return Content
     */
    public function edit(Request $request, $id)
    {
        $edit = $this->data->findOrFail($id);
     
        $permissions = config('nue.database.permissions_model')::pluck('name', 'id');

        return view("{$this->view}.edit", compact('edit', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $edit = $this->data->findOrFail($id);

        $this->validate($request, [
            'slug' => 'required', 
            'name' => 'required', 
        ]);

        $input = $request->all();
        
        $edit->update($input);
        $edit->permissions()->sync($request->permissions);
        
        notify()->flash($this->tUpdate, 'success');
        return redirect(route("$this->prefix.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->has('pilihan')):
            foreach($request->pilihan as $temp):
                $data = $this->data->findOrFail($temp);
                $data->delete();
            endforeach;
            
            notify()->flash($this->tDelete, 'success');
            return redirect()->back();
        endif;
    }

    /**
     * Datatable API
     * @param  $data
     * @return Datatable
     */
    public function datatable($data) 
    {
        return datatables()->of($data)
            ->editColumn('pilihan', function($data) {
                return '<div class="form-check mb-0">
                    <input type="checkbox" class="form-check-input pilihan" id="pilihan['.$data->id.']" name="pilihan[]" value="'.$data->id.'">
                        <label class="form-check-label" for="pilihan['.$data->id.']"></label>
                    </div>';
            })
            ->editColumn('permission', function($data) {
                $return = '';
                foreach($data->permissions as $temp) {
                    $return .= '<label class="badge bg-success me-1">'.$temp->name.'</label>';
                }
                return $return;
            })
            ->editColumn('action', function($data) {
                return '<a href="'.route("$this->prefix.edit", $data->id).'" class="link link-secondary">
                        <span class="iconify" data-icon="uil:edit"></span> <span class="">Edit</span>
                    </a>';

                return $return;
            })
            ->escapeColumns(['*'])->toJson();
    }
}