<?php

namespace App\Http\Controllers;

use App\SupplierOrder;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Order;

class SupplierOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $result = 0;
         try {
            DB::beginTransaction();

            $supplierOrder = new SupplierOrder();
            $supplierOrder->user_id = $user->id; //Supplier Id
            $supplierOrder->order_id =  $request->order_id;
            $supplierOrder->deliver_date =  $request->deliver_date;
            $supplierOrder->deliver_note =  $request->deliver_note;
            $supplierOrder->save();

            $order = Order::findOrFail($request->order_id);
            $order->deliver_date = $request->deliver_date;
            $order->deliver_note =  $request->deliver_note;
            $order->status = $request->status;
            $result = $order->save(); 

            DB::commit();
            return $result;
         } catch (Exception $ex) {
            DB::rollBack();
            return $ex;
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SupplierOrder  $supplierOrder
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    { 
            $rpp = $request->rpp;
            $selectedArea = $request->selectedArea;           
            
            $user = Auth::user();
            return  DB::table('orders')
                    ->join('supplier_orders','supplier_orders.order_id','orders.id')
                    ->join('users','users.id','supplier_orders.user_id') 
                    ->join('areas','areas.id','orders.area_id')
                    ->join('items','items.id','orders.item_id')
                    ->select('orders.*','areas.name as area_name','items.name') 
                    ->where('users.id',$user->id)
                    ->where('areas.name','LIKE','%'.$selectedArea.'%')
                    ->orderBy('orders.id','DESC')
                    ->paginate($rpp);
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SupplierOrder  $supplierOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplierOrder $supplierOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SupplierOrder  $supplierOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplierOrder $supplierOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SupplierOrder  $supplierOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierOrder $supplierOrder)
    {
        //
    }
}
