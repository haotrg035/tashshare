<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('numberuri', ['only' => 'show']);
        $this->middleware('loggedin');
    }

    public function show($id){

    }
}
