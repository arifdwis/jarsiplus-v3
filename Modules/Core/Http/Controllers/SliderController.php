<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\Slider;

class SliderController extends Controller
{
   protected $title = 'Slider';

    /**
     * Siapkan konstruktor controller
     * 
     * @param Slider $data
     */
    public function __construct(Slider $data) 
    {
        $this->data = $data;

        $this->toIndex = route('epanel.slider.index');
        $this->prefix = 'epanel.slider';
        $this->view = 'core::slider';

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
     * Tampilkan halaman utama modul yang dipilih
     * 
     * @param Request $request
     * @return Response|View
     */
    public function index(Request $request) 
    {
        $data = $this->data->latest()->get();

        if($request->has('datatable')):
            return $this->datatable($data);
        endif;

        return view("$this->view.index", compact('data'));
    }

    /**
     * Tampilkan halaman untuk menambah data
     * 
     * @return Response|View
     */
    public function create() 
    {
        return view("$this->view.create");
    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param Request $request
     * @return Response|View
     */
    public function store(Request $request) 
    {
        $input = $request->all();
        $input['slug'] = str_slug($request->label);
        $input['id_operator'] = optional(auth()->user())->id;

        if($request->hasFile('file')):
            $input['file'] = $this->upload($request->file('file'), uuid());
        endif;

        // return $input;
        $this->data->create($input);

        notify()->flash($this->tCreate, 'success');
        return redirect($this->toIndex);
    }

    /**
     * Menampilkan detail lengkap
     * 
     * @param Int $id
     * @return Response|View
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Tampilkan halaman perubahan data
     * 
     * @param Int $id
     * @return Response|View
     */
    public function edit($id)
    {
        $edit = $this->data->uuid($id)->firstOrFail();

        return view("$this->view.edit", compact('edit'));
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
        $edit = $this->data->uuid($id)->firstOrFail();

        $input = $request->all();
        $input['slug'] = str_slug($request->label);
        if($request->hasFile('file')):          
            deleteImg($edit->file);
            $input['file'] = $this->upload($request->file('file'), uuid());
        else:
            $input['file'] = $edit->file;
        endif;
        
        $edit->update($input);

        notify()->flash($this->tUpdate, 'success');
        return redirect($this->toIndex);
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
        $ids = $request->get('ids', $request->get('pilihan', []));

        if ($id === 'hapus-all' || !empty($ids)) {
            if (!empty($ids) && is_array($ids)) {
                $sliders = $this->data->whereIn('id', $ids)->orWhereIn('uuid', $ids)->get();
                foreach ($sliders as $slider) {
                    if (!empty($slider->file)) {
                        deleteImg($slider->file);
                    }
                    $slider->delete();
                }
            }
        } else {
            $slider = $this->data->where('uuid', $id)->orWhere('id', $id)->first();
            if ($slider) {
                if (!empty($slider->file)) {
                    deleteImg($slider->file);
                }
                $slider->delete();
            }
        }

        if (function_exists('notify')) {
            notify()->flash($this->tDelete, 'success');
        }

        return redirect($this->toIndex)->with('success', $this->tDelete);
    }

    /**
     * Function for Upload File
     * 
     * @param  $file, $filename
     * @return URI
     */
    public function upload($file, $filename) 
    {
        $tmpFilePath = 'app/public/sikerja/slider/';
        $tmpFileDate =  date('Y-m') .'/'.date('d').'/';
        $tmpFileName = $filename;
        $tmpFileExt = $file->getClientOriginalExtension();

        makeImgDirectory($tmpFilePath . $tmpFileDate);
        
        $nama_file = $tmpFilePath . $tmpFileDate . $tmpFileName;
        
        \Image::make($file->getRealPath())->resize(800, 400, function($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path() . "/$nama_file.$tmpFileExt");
        
        \Image::make($file->getRealPath())->fit(150, 50)->save(storage_path() . "/{$nama_file}_m.$tmpFileExt");

        return "storage/sikerja/slider/{$tmpFileDate}{$tmpFileName}.{$tmpFileExt}";
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
            ->addColumn('pilihan', function($data) {
                return '<div class="form-check mb-0"><input type="checkbox" name="ids[]" value="'.$data->id.'" class="form-check-input check-id"><label class="form-check-label"></label></div>';
            })
            ->editColumn('file', function($data) {
                if ($data->file) {
                    $src = viewImg($data->file, 'm');
                    return '<a href="'.viewImg($data->file, 'l').'" data-lity><img src="'.$src.'" height="35" class="rounded border" style="object-fit:cover;"></a>';
                }
                return '-';
            })
            ->editColumn('judul', function($data) {
                return $data->label ?? $data->judul;
            })
            ->addColumn('action', function($data) {
                $updateUrl = route($this->prefix.'.update', $data->uuid ?? $data->id);
                $deleteUrl = route($this->prefix.'.destroy', $data->uuid ?? $data->id);
                $labelAttr = htmlspecialchars($data->label ?? $data->judul, ENT_QUOTES, 'UTF-8');
                $fileAttr = viewImg($data->file, 'm');

                return '<div class="btn-group btn-group-xs">
                    <button type="button" class="btn btn-xs btn-outline-secondary" onclick="openEditSliderModal(\''.$updateUrl.'\', \''.$labelAttr.'\', \''.$fileAttr.'\')"><i class="bi-pencil me-1"></i> Edit</button>
                    <button type="button" class="btn btn-xs btn-outline-danger" onclick="deleteSliderItem(\''.$deleteUrl.'\')"><i class="bi-trash me-1"></i> Hapus</button>
                </div>';
            })
            ->rawColumns(['pilihan', 'file', 'action'])
            ->make(true);
    }
}
