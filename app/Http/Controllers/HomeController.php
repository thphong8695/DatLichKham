<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use DB;
class HomeController extends Controller
{
	function __construct()
    {
        $this->middleware('auth');
		// $this->middleware('permission:DlBv106x-list|DlBv106x-create|DlBv106x-edit|DlBv106x-delete', ['only' => ['index','store']]);
		// $this->middleware('permission:DlBv106x-create', ['only' => ['create','store']]);
		// $this->middleware('permission:DlBv106x-edit', ['only' => ['edit','update']]);
		// $this->middleware('permission:DlBv106x-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
    	$user = Auth::user();

        $roles = Role::pluck('id','name')->all();
        $permission = Permission::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        dd($user->getAllPermissions()->pluck('name','name')->all());
        foreach ($user->getAllPermissions() as $key => $value) {
            
        }
        // dd($user->getAllPermissions());
    	return view('pages.anbinh.index');
    	// dd($user->first()->name);
    }
}
