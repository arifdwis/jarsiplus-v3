<?php

namespace Modules\Template\Http\Controllers\Settings;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AccountController extends Controller
{
    public function index()
    {
        return view('template::settings.index');
    }

    public function update(Request $request, $id)
    {
        notify()->flash('Account updated successfully!', 'success');
        return redirect()->back();
    }
}
