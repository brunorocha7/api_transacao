<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function getAll()
    {
        $users = Usuarios::all();
        return $users;
    }

    public function get($id)
    {
        $user = Usuarios::find($id);
        return $user;
    }

    public function create(Request $request)
    {
        $user = Usuarios::create($request->all());
        return $user;
    }
        
}
