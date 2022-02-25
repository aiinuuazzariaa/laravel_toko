<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function show(){
        return Orders::all();
    }
    
    public function detail($id)
    {
        if(Orders::where('id_orders', $id)->exists()) { 
            $data = DB::table('orders')
            ->where('id_orders', '=', $id) 
            ->select('orders.*')
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
                'id_customers' => 'required',
                'id_officer' => 'required'
            ] 
        ); 
 
        if($validator->fails()) { 
            return Response()->json($validator->errors()); 
        } 
 
        $ubah = Orders::where('id_orders', $id)->update([ 
            'id_customers' => $request->id_customers, 
            'id_officer' => $request->id_officer, 
            'tgl_orders' => date("Y-m-d")
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
                'id_customers' => 'required',
                'id_officer' => 'required'
            ] 
        ); 
 
        if($validator->fails()) { 
            return Response()->json($validator->errors()); 
        } 
 
        $simpan = Orders::create([ 
            'id_customers' => $request->id_customers, 
            'id_officer' => $request->id_officer,
            'tgl_orders' => date("Y-m-d")
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
        $hapus = Orders::where('id_orders', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}


