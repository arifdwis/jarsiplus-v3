<?php

namespace Modules\Template\Http\Controllers\Settings;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Pemohon\Entities\Pemohon;

class ProfileController extends Controller
{
    protected $title = 'Biodata';

    public function __construct(Pemohon $data) 
    {
        $this->data = $data;
        
        $this->module   = strtolower('Template');
        $this->entiti   = strtolower('Profile');
        $this->view     = $this->module.'::settings.'.$this->entiti;
        $this->prefix   = 'settings.'.$this->entiti;

        $this->tCreate = "$this->title created successfully!";
        $this->tUpdate = "$this->title updated successfully!";

        view()->share([
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    public function index()
    {
        $user = me();
        $data = $this->data::where('id_operator',$user->id)->first();
        
        if(!$data):
            $input['name'] = $user->name;
            $input['email'] = $user->email;
            $input['phone'] = $user->phone;
            $input['nik']   = $user->nik;
            $input['address'] = $user->address;
            $input['gender']  = $user->gender;
            $input['id_operator'] = $user->id;
            $data = $this->data::create($input);
        endif;

        return view("$this->view.index",compact('data'));
    }

    public function update(Request $request,$uuid)
    {
        $edit = $this->data::where('id_operator', me()->id)->where('uuid',$uuid)->firstOrFail();
        $input = $request->validate([
            'name' => 'required|string',
            'nickname' => 'required|string',
            'nik' => 'required|string',
            'gender' => 'nullable|in:L,P',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'nullable|string',
            'unit_kerja' => 'required|string',
            'nip' => 'required|string',
            'jabatan' => 'required|string',
            'kota_id' => 'required|string|regex:/^[^;]+;.+$/',
        ]);
        $exp = explode(";",$input['kota_id']);
        $input['kota'] = $exp[1];
        $input['kota_id'] = $exp[0];
        $edit->update($input);
        notify()->flash($this->tUpdate, 'success');
        return redirect()->back();
    }
}
