<?php

namespace Nue\Lock\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Novay\Nue\Facades\Nue;
use Nue\Lock\Lock;

class LockController extends Controller
{
    public function lock()
    {
        if (! Nue::user() ) {
            return redirect(config('nue.route.prefix'));
        }

        if (! $url = session()->get(Lock::LOCK_KEY) ) {
            $url = url()->previous();
            session()->put(Lock::LOCK_KEY, $url);
        }

        return view('nue-lockscreen::lock');
    }

    public function unlock(Request $request)
    {
        if (! Nue::user() ) {
            return redirect(config('nue.route.prefix'));
        }

        if (! session()->has(Lock::LOCK_KEY) ) {
            return redirect(nue_url());
        }

        if ( Hash::check(trim($request->get('password')), Nue::user()->password) ) {
            $previous = session()->get(Lock::LOCK_KEY);

            session()->forget(Lock::LOCK_KEY);

            return redirect($previous);
        }

        notify()->flash('Password incorrect.', 'danger');
        return redirect()->back();
    }
}