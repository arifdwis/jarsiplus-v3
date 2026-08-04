<?php

namespace Modules\Template\Http\Controllers\Settings;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pemohon\Entities\Pemohon;
use Modules\Pemohon\Entities\Corporate;

class ProfileController extends Controller
{
    protected $title = 'Profil Diri & Instansi';
    protected $data;
    protected $corporate;
    protected $module;
    protected $entiti;
    protected $view;
    protected $prefix;
    protected $tCreate;
    protected $tUpdate;

    public function __construct(Pemohon $data, Corporate $corporate) 
    {
        $this->data = $data;
        $this->corporate = $corporate;
        
        $this->module   = strtolower('Template');
        $this->entiti   = strtolower('Profile');
        $this->view     = $this->module.'::settings.'.$this->entiti;
        $this->prefix   = 'settings.'.$this->entiti;

        $this->tCreate = "$this->title created successfully!";
        $this->tUpdate = "Profil Diri dan Data Instansi berhasil disimpan!";

        view()->share([
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    public function index()
    {
        $user = me();
        
        // Fetch or create Pemohon
        $data = $this->data::where('id_operator', $user->id)->first();
        if (!$data) {
            $data = $this->data::create([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
                'nik'   => $user->nik ?? '',
                'address' => $user->address ?? '',
                'gender'  => $user->gender ?? 'L',
                'id_operator' => $user->id,
            ]);
        }

        // Fetch or create Corporate
        $corporate = $this->corporate::where('id_operator', $user->id)->first();
        if (!$corporate) {
            $corporate = $this->corporate::create([
                'id_operator' => $user->id,
                'name' => $data->unit_kerja ?? '',
                'email' => $user->email,
                'phone' => $user->phone ?? '',
                'address' => $user->address ?? '',
            ]);
        }

        $kotas = class_exists('\Modules\Wilayah\Entities\Kota') 
            ? \Modules\Wilayah\Entities\Kota::orderBy('name', 'asc')->get() 
            : collect();

        return view("$this->view.index", compact('data', 'corporate', 'kotas'));
    }

    public function update(Request $request, $uuid = null)
    {
        $user = me();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:30',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'unit_kerja' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'address' => 'required|string',
            'corporate_name' => 'required|string|max:255',
            'corporate_email' => 'required|email|max:255',
            'corporate_phone' => 'required|string|max:30',
            'corporate_address' => 'required|string',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK (Nomor Induk Kependudukan) wajib diisi.',
            'email.required' => 'Alamat email pemohon wajib diisi.',
            'phone.required' => 'Nomor WhatsApp / telepon wajib diisi.',
            'unit_kerja.required' => 'Unit kerja / sub-instansi wajib diisi.',
            'jabatan.required' => 'Jabatan pemohon wajib diisi.',
            'address.required' => 'Alamat domisili lengkap wajib diisi.',
            'corporate_name.required' => 'Nama instansi / OPD corporate wajib diisi.',
            'corporate_email.required' => 'Email resmi instansi wajib diisi.',
            'corporate_phone.required' => 'No. telepon kantor instansi wajib diisi.',
            'corporate_address.required' => 'Alamat kantor instansi wajib diisi.',
        ]);

        // 1. Update Pemohon
        $pemohon = $this->data::where('id_operator', $user->id)->first();
        if (!$pemohon) {
            $pemohon = $this->data::create(['id_operator' => $user->id]);
        }

        $pemohonData = [
            'name' => $request->name,
            'nickname' => $request->nickname,
            'nik' => $request->nik,
            'nip' => $request->nip,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender ?? 'L',
            'date_birth' => $request->date_birth,
            'unit_kerja' => $request->unit_kerja,
            'jabatan' => $request->jabatan,
            'address' => $request->address,
        ];

        if (!empty($request->kota_id) && str_contains($request->kota_id, ';')) {
            $exp = explode(";", $request->kota_id);
            $pemohonData['kota'] = $exp[1];
            $pemohonData['kota_id'] = $exp[0];
        }

        $pemohon->update($pemohonData);

        // 2. Update Corporate
        $corporate = $this->corporate::where('id_operator', $user->id)->first();
        if (!$corporate) {
            $corporate = $this->corporate::create(['id_operator' => $user->id]);
        }

        $corporateData = [
            'name' => $request->corporate_name,
            'email' => $request->corporate_email,
            'phone' => $request->corporate_phone,
            'website' => $request->corporate_website,
            'postal_code' => $request->corporate_postal_code,
            'address' => $request->corporate_address,
        ];

        if (!empty($request->corporate_kota_id) && str_contains($request->corporate_kota_id, ';')) {
            $expC = explode(";", $request->corporate_kota_id);
            $corporateData['kota'] = $expC[1];
            $corporateData['kota_id'] = $expC[0];
        }

        $corporate->update($corporateData);

        // 3. Update User
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
        }

        if (function_exists('notify')) {
            notify()->flash($this->tUpdate, 'success');
        }

        return redirect()->route('permohonan.index');
    }
}
