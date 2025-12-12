<?php

namespace App\Http\Controllers;

use App\Models\crudmodels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class crudcontroller extends Controller
{
    public function index()
    {
        return view('crudview');
    }

    public function crudcreate(request $request){
        $data= new crudmodels;

        $data->name= $request->name;
        $data ->save();
        return view('crudview',compact($data));
    }
}
