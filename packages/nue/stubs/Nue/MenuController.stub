<?php

namespace App\Http\Controllers\Nue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Menu';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->models = config('nue.database.menu_model');
        $this->data = new $this->models;

        $this->prefix = 'settings.menu';
        $this->view = 'nue::settings.menu';

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
        $options = config('nue.database.menu_model')::selectOptions();

        return view("$this->view.index", compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        if($request->filled('purpose')):
            if($request->purpose == 'add'):
                $this->validate($request, [
                    'title' => 'required', 
                    'icon' => 'required', 
                ]);

                $input = $request->all();
                $save = $this->data->create($input);
                $save->roles()->sync($request->roles);

                notify()->flash('Menu has been created.', 'success');
                return redirect()->back();
            endif;
        endif;

        $order = json_decode($request->order);
        foreach($order as $i => $temp):
            $sort = $this->data->find($temp->id);
            $sort->parent_id = 0;
            $sort->order = $i;
            $sort->save();

            if(isset($temp->children)):
                foreach($temp->children as $ii => $side):
                    $sort_sub = $this->data->find($side->id);
                    $sort_sub->parent_id = $temp->id;
                    $sort_sub->order = $ii;
                    $sort_sub->save();
                endforeach;
            endif;
        endforeach;

        notify()->flash('Menu has been sorted.', 'success');
        return redirect(route("$this->prefix.index"));
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

        $options = config('nue.database.menu_model')::selectOptions();

        return view("$this->view.edit", compact('edit', 'options'));
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
            'title' => 'required', 
            'icon' => 'required', 
        ]);

        $edit->update($request->all());
        $edit->roles()->sync($request->roles);

        notify()->flash('Menu has been updated.', 'success');
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
        $delete = $this->data->destroy($id);

        return $delete ? 'success' : 'failed';
    }
}