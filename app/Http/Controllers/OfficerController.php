<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Officer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OfficerController extends Controller
{
    public function show(){
        return officer::all();
    }
    
    public function detail($id)
    {
        if(officer::where('id_officer', $id)->exists()) { 
            $data = DB::table('officer')
            ->where('id_officer', '=', $id) 
            ->select('officer.*')
            ->get();

            return Response()->json($data);
        } 
        else { 
            return Response()->json(['message' => 'Tidak ditemukan' ]); 
        } 
        
    }

    public function update($id, Request $request) 
    { 
        $validator=Validator::make($request->all(), 
            [ 
                'nama_officer' => 'required',
                'username' => 'required', 
                'password' => 'required', 
                'level' => 'required' 
            ] 
        ); 
 
        if($validator->fails()) { 
            return Response()->json($validator->errors()); 
        } 
 
        $ubah = officer::where('id_officer', $id)->update([ 
            'nama_officer' => $request->nama_officer, 
            'username' => $request->username, 
            'password' => Hash::make($request->password),
            'level' => $request->level 
        ]); 
 
        if($ubah) { 
            return Response()->json(['status' => 1]); 
        } 
        else { 
            return Response()->json(['status' => 0]); 
        } 
    } 

    public function store(Request $request) 
    { 
        $validator=Validator::make($request->all(), 
            [ 
                'nama_officer' => 'required',
                'username' => 'required', 
                'password' => 'required', 
                'level' => 'required'
            ] 
        ); 
 
        if($validator->fails()) { 
            return Response()->json($validator->errors()); 
        } 
 
        $simpan = officer::create([ 
            'nama_officer' => $request->nama_officer, 
            'username' => $request->username, 
            'password' => Hash::make($request->password),
            'level' => $request->level 
        ]); 
 
        if($simpan) { 
            return Response()->json(['status'=>1]); 
        } 
        else { 
            return Response()->json(['status'=>0]); 
        } 
    }

    public function destroy($id)
    {
        $hapus = officer::where('id_officer', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}
