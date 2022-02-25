<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetailOrder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DetailOrdersController extends Controller
{
    public function show()
    {
        $data = DB::table('detail_order')
            ->join('orders', 'detail_order.id_orders', '=', 'orders.id_orders')
            ->join('product', 'detail_order.id_product', '=', 'product.id_product')
            ->select('detail_order.id_detail_order','orders.id_orders', 'orders.tgl_orders', 'product.nama_product', 'detail_order.qty', 'detail_order.subtotal')
            ->get();
        return Response()->json($data);
    }
    
    public function detail($id)
    {
        if(DetailOrder::where('id_detail_order', $id)->exists()) { 
            $data = DB::table('detail_order')
            ->where('id_detail_order', '=', $id) 
            ->select('detail_order.*')
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
                'id_orders' => 'required', 
                'id_product' => 'required', 
                'qty' => 'required'
            ] 
        ); 
 
        if($validator->fails()) { 
            return Response()->json($validator->errors()); 
        } 
 
        $id_product = $request->id_product;
        $qty = $request->qty;
        $harga = DB::table('product')->where('id_product',$id_product)->value('harga');
        $subtotal = $harga * $qty;

        $ubah = DetailOrder::where('id_detail_order', $id)->update([ 
            'id_orders' => $request->id_orders, 
            'id_product' => $request->id_product, 
            'qty' => $request->qty, 
            'subtotal' => $subtotal
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
                'id_orders' => 'required', 
                'id_product' => 'required', 
                'qty' => 'required'
            ] 
        ); 
 
        if($validator->fails()) { 
            return Response()->json($validator->errors()); 
        } 
        
        $id_product = $request->id_product;
        $qty = $request->qty;
        $harga = DB::table('product')->where('id_product',$id_product)->value('harga');
        $subtotal = $harga * $qty;

        $simpan = DetailOrder::create([ 
            'id_orders' => $request->id_orders, 
            'id_product' => $request->id_product, 
            'qty' => $request->qty, 
            'subtotal' => $subtotal
        ]); 
 
        if($simpan) { 
            return Response()->json(['status'=>1]); 
        } 
        else { 
            return Response()->json(['status'=>0]); 
        } 
    }

    public function destroy($id){
        $hapus = DetailOrder::where('id_detail_order', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }

}
