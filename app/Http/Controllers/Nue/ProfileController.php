<?php

namespace App\Http\Controllers\Nue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user profile screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view('profile.show', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }

    /**
     * Update some changes about your profile informations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function update(Request $request)
    {
        $input = $request->all();

        if(!$request->filled('page')) {
            $this->validate($request, [
                'name' => 'required', 
                'photo' => 'mimes:jpeg,png,jpg', 
            ]);

            if (isset($input['photo'])) {
                me()->updateProfilePhoto($input['photo']);
            }

        } else {
            switch($request->page):
                case 'email':
                    $this->validate($request, [
                        'email' => 'required|email|unique:users,email,'.me()->id, 
                        'old_password' => 'required|current_password',
                    ]);
                break;
                case 'password':
                    $this->validate($request, [
                        'old_password' => 'required|current_password',
                        'new_password' => 'required|min:3|different:old_password',
                        'new_password_confirmation' => 'required|same:new_password',
                    ]);

                    $input['password'] = $request->filled('new_password') ? bcrypt($request->new_password) : me()->password;
                break;
                default:
                    abort(404);
                break;
            endswitch;
        }

        me()->update($input);

        notify()->flash('Informasi profile berhasil diperbarui!', 'success');
        return redirect()->back();
    }

    /**
     * Delete or terminate account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|current_password',
        ]);

        $user = me();
        DB::transaction(function () use ($user) {
            $user->deleteProfilePhoto();
            $user->delete();
        });

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect('/');
    }
}
