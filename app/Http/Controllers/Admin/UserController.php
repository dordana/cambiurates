<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $module = 'admin';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sSearch = \Request::get('search');

        return view('admin.users.list',
            [
                'title' => 'Users',
                'aUsers' => User::where('name', 'LIKE', '%'.trim($sSearch).'%')
                    ->orWhere('email', 'LIKE', '%'.trim($sSearch).'%')
                    ->orderBy('id', 'desc')
                    ->paginate($this->limit)
            ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit()
    {
        $oUser = \Auth::user();

        if (!$oUser) {
            return route('users');
        }
        
        return view('admin.auth.edit', ['oUser' => $oUser]);
    }

    /**
     * @param $iUserId
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($iUserId)
    {
        $oUser = User::find($iUserId);

        if (!$oUser) {
            return redirect('admin/users')->with(['not_found' => 'Sorry, we couldn\'t find that user.']);
        }

        // if you try delete it myself by mistake
        if ($oUser->id == \Auth::user()->id || $oUser->role == 'admin') {
            return redirect('admin/users')->with(['not_found' => 'Sorry, you couldn\'t delete that user.']);
        }

        $oUser->delete();

        return redirect('admin/users')->with(['success' => 'User successfully deleted!']);
    }
}
