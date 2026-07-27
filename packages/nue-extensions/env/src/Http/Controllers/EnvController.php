<?php

namespace Nue\Env\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Nue\Env\Models\Env;

class EnvController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Env Manager';

    private $data;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->data = new Env();
        
        $this->prefix = 'nue.env';
        $this->view = 'nue-env::';

        $this->tCreate = "$this->title baru berhasil dibuat!";
        $this->tUpdate = "$this->title berhasil diubah!";
        $this->tDelete = "Some $this->title berhasil dihapus!";

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
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = $this->data->getEnv();

        if ( $request->has('datatable') ) {
            return $this->datatable($data);
        }

        return nue_view("{$this->view}.index", [
            'title' => $this->title, 
            'data' => $data
        ]);
    }

    /**
     * Tampilkan halaman untuk menambah data
     * 
     * @return Response|View
     */
    public function create() 
    {
        return nue_view("{$this->view}.create", [
            'title' => $this->title
        ]);
    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param Request $request
     * @return Response|View
     */
    public function store(Request $request) 
    {
        $this->validate($request, [
            'key' => 'required', 
            'value' => 'required', 
        ]);

        $simpan = new $this->data;
        
        $simpan->key = $request->key;
        $simpan->value = $request->value;

        $simpan->save();
        
        nue_notify($this->tCreate, 'success');
        return redirect(route("$this->prefix.index"));
    }

    /**
     * Tampilkan halaman perubahan data
     * 
     * @param Int $id
     * @return Response|View
     */
    public function edit(Request $request, $id)
    {
        return nue_view("{$this->view}.edit", [
            'title' => $this->title, 
            'edit' => $this->data->findOrFail($id)
        ]);
    }

    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param Request $request
     * @param Int $id
     * @return Response|View
     */
    public function update(Request $request, $id)
    {
        $edit = $this->data->findOrFail($id);

        $this->validate($request, [
            'key' => 'required', 
            'value' => 'required', 
        ]);

        $edit->key = $request->key;
        $edit->value = $request->value;
        $edit->save();

        nue_notify($this->tUpdate, 'success');
        return redirect(route("$this->prefix.index"));
    }

    /**
     * Lakukan penghapusan data yang tidak diinginkan
     * 
     * @param Request $request
     * @param Int $id
     * @return Response|String
     */
    public function destroy(Request $request, $id)
    {
        if($request->has('pilihan')):
            foreach($request->pilihan as $temp):
                switch($id):
                    case 'bulk-delete':
                        $this->data->deleteEnv($temp);
                    break;
                    default:
                    break;
                endswitch;
            endforeach;
            return 'success';
        endif;
    }

    /**
     * Datatable API
     * 
     * @param  $data
     * @return Datatable
     */
    public function datatable($data) 
    {
        return datatables()->of($data)
            ->editColumn('pilihan', function($data) {
                $return = '<div class="form-check">
                        <input class="form-check-input pilihan" type="checkbox" name="pilihan[]" id="pilihan['.$data['id'].']" value="'.$data['id'].'"> 
                        <label class="form-check-label" for="pilihan['.$data['id'].']"></label>
                    </div>';

                return $return;
            })
            ->editColumn('key', function($data) {
                return '<code>'.$data['key'].'</code>';
            })
            ->editColumn('action', function($data) {
                return '<a href="'.route("$this->prefix.edit", $data['id']).'" class="btn btn-xs btn-info rounded-xs" data-pjax>
                        <i class="bi bi-pencil-square"></i>
                        '.__('Edit').'
                    </a>';
            })
            ->escapeColumns(['*'])->toJson();
    }
}
