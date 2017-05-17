<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('confirmation');
    }

    public function index()
    {

    	//We required from the client to not have home nav item!
	    //So redirect according role. For more info see http://redmine.zenlime.com/redmine/issues/1091
    	$userRole = \Auth::user()->role;
		switch ($userRole) {
			case 'admin':
				return redirect()->route('users');
				break;
			case 'user':
				return redirect()->route('exchangeRates');
				break;
		}

        return view('admin.admin.index');
    }
}
