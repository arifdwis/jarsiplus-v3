<?php

namespace Modules\Formulir\Http\Controllers\Beimbai;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Formulir\Entities\Permohonan;
use Modules\Core\Entities\Histori;
use Modules\Formulir\Entities\Penilaian;
use App\Observers\HistoriObserver;
use App\Observers\PenilaianObserver;

class PermohonanController extends Controller
{

 protected $title = 'Pengajuan Inovasi Daerah';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct(Permohonan $data, Histori $histori) 
    {
        $this->data = $data;
        $this->histori = $histori;
        $this->toIndex = route('epanel.permohonan.index');
        $this->prefix = 'epanel.permohonan';
        $this->view = 'formulir::permohonan';

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
        $data = $this->data::orderBy('created_at','asc')->get();
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
        $show = $this->data->uuid($id)->firstOrFail();
        return $show;
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
        $allowedStatuses = [
            0 => [1, 9],
            1 => [2],
            3 => [4],
        ];

        $input = $request->validate([
            'status' => ['required', Rule::in($allowedStatuses[(int) $edit->status] ?? [])],
            'alasan_tolak' => 'required_if:status,9|nullable|string',
        ]);

        if ((int) $input['status'] !== 9) {
            unset($input['alasan_tolak']);
        }

        $edit->update($input);

        if ($edit->status == 4) {
            $penilaian = Penilaian::where('inovasi_id', $edit->id)->get();
            $totalBobot = $penilaian->sum('bobot');

            $permohonan = Permohonan::findOrFail($edit->id);
            $permohonan->nilai_akhir = $totalBobot;

            $permohonan->save();
        }

        
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
        ->editColumn('kode', function($data) {
            $return  = $data->kode;
            return $return;
        })
        ->editColumn('pemohon', function($data) {
           $return  = optional($data->pemohon1)->name.'<br>'.'<label class="badge bg-primary">'.'NIP : '.optional($data->pemohon1)->nip.'</label>'.'<br>'.'<label class="badge bg-success">'.'NIK : '.optional($data->pemohon1)->nik.'</label>';
           return $return;
       })
        ->editColumn('kota', function($data) {
            $return  = $data->pemohon1->unit_kerja;
            return $return;
        })
        ->editColumn('keperluan', function($data) {
            $return  = $data->label;
            return $return;
        })
        ->editColumn('file', function($data) {
            if ($data->status == 4) {
                $return  = 'Telah Selesai';
            }
            else{
                if (me()->roles->first()->id != 5) {
                    return
                    '<a href="'.route("$this->prefix.penilaian.index", $data->uuid).'" class="link link-secondary">
                    <span class="iconify" data-icon="mdi:home-clock"></span> <span class="">Indikator</span>
                    </a>';
                }else{
                   return
                   '<a href="'.route("$this->prefix.penilaian.index", $data->uuid).'" class="link link-secondary">
                   <span class="iconify" data-icon="mdi:home-clock"></span> <span class="">Data Dukung</span>
                   </a>';
               }
           }

           return $return;
       })
        ->editColumn('action', function($data) {
            if (me()->roles->first()->id != 5) {
                if ($data->status == 2) {
                    return '<a href="'.route("$this->prefix.edit", $data->uuid).'" class="link link-secondary">
                    <span class="iconify" data-icon="eos-icons:virtual-host-manager"></span> <span class="">Manage</span>
                    </a>' . 

                    '<a href="'.route("$this->prefix.persetujuan.index", $data->uuid).'" class="link link-secondary">
                    <span class="iconify" data-icon="mdi:home-clock"></span> <span class="">Approve</span>
                    </a>';
                }
                if ($data->status == 4) {
                    $return  = 'Telah Selesai';
                }
                else{
                 return '<a href="'.route("$this->prefix.edit", $data->uuid).'" class="link link-secondary">
                 <span class="iconify" data-icon="eos-icons:virtual-host-manager"></span> <span class="">Manage</span>
                 </a>';
             }
             return $return;
         } else{
            return '<a href="'.route("$this->prefix.show", $data->uuid).'" class="link link-secondary">
               <span class="iconify" data-icon="eos-icons:virtual-host-manager"></span> <span class="">Lihat Data</span>
               </a>';
        }
        return $return;
    })
        ->escapeColumns(['*'])->toJson();
    }
}
