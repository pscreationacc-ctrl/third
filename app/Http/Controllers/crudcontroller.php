<?php

namespace App\Http\Controllers;

use App\Models\crudmodels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class crudcontroller extends Controller
{
    public function index()
    {
        $data = crudmodels::all();
        return view('crudview', compact('data'));
    }

    public function crudcreate(request $request){
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $data = new crudmodels;
        $data->name = $request->name;
        $data->save();

        return redirect()->route('crud.index')->with('success', 'Entry created successfully!');
    }

    public function crudgetedit(){
        $info = crudmodels::all();
        return view('crudedit', compact('info'));
    }

    public function crudedit(Request $request, $id){
        $item= crudmodels::findOrFail($id);

        $item ->update([
            'name' => $request->name,
        ]);
            return redirect(route('crud.index'));
    }

    public function cruddelete($id){
        $item= crudmodels::findOrFail($id);
        $item->delete();
        return redirect(route('crud.index'));
    }

}
