<?php

namespace App\Http\Controllers\Nue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use Novay\Nue\Models\ActivityLog;

class LogActivityController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Log Activity';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ActivityLog $data) 
    {
        $this->data = $data;
        
        $this->prefix = 'settings.log-activity';
        $this->view = 'nue::settings.log-activity';

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
        $data = $this->data->with('user')->latest();

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
        
        $role = $this->data->create($request->all());
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
        
        $edit->update($request->all());
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
            ->editColumn('user', function($data) {
                return optional($data->user)->name;
            })
            ->editColumn('method', function($data) {
                $color = Arr::get(ActivityLog::$methodColors, $data->method, 'bg-secondary');

                return "<span class=\"badge bg-$color\">$data->method</span>";
            })
            ->editColumn('path', function($data) {
                return '<label class="badge bg-info">'.$data->path.'</label>';
            })
            ->editColumn('ip', function($data) {
                return '<label class="badge bg-primary">'.$data->ip.'</label>';
            })
            ->editColumn('input', function($data) {
                $input = json_decode($data->input, true);
                $input = Arr::except($input, ['_token', '_method', '_previous_']);
                if (empty($input)) {
                    return '<code>{}</code>';
                }

                return '<pre>'.json_encode($input, JSON_PRETTY_PRINT | JSON_HEX_TAG).'</pre>';
            })
            ->escapeColumns(['*'])->toJson();
    }
}