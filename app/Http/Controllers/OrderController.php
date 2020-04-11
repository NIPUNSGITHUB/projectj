<?php

namespace App\Http\Controllers;

use App\Order;
use App\Item;
use App\Area;
use Illuminate\Http\Request;
use Auth;
use DB;

class OrderController extends Controller
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

    public function CustomerOrderPlaceInitialData()
    {
        $user = Auth::user();
        $items = Item::select('id','name')->get();        
        $order_count = Order::where('user_id',$user->id)->count();   
        $deliverd = Order::where('status',1)->count();   
        $pending = Order::where('status',0)->count();   
        $areas = Area::select('id','name')->get();
      
        return array('items'=>$items,'order_count'=>$order_count,'deliverd'=>$deliverd,'pending'=>$pending,'areas'=>$areas);
        
    }

    public function CustomerOrderDetails(Request $request)
    {
        $rpp = $request->rpp;
        $user = Auth::user();
        return  DB::table('orders')
                ->join('items','items.id','orders.item_id')
                ->select('orders.*','items.name')
                ->where('user_id',$user->id)
                ->orderBy('orders.id','DESC')
                ->paginate($rpp);
    }

    public function AllCustomerOrderDetails(Request $request)
    {
        $rpp = $request->rpp;
        $selectedArea = $request->selectedArea;
       
        
        $user = Auth::user();
        return  DB::table('orders')
                ->join('items','items.id','orders.item_id')
                ->join('users','users.id','orders.user_id')
                ->join('areas','areas.id','users.area_id')
                ->select('orders.*','areas.name as area_name','items.name') 
                ->where('areas.name','LIKE','%'.$selectedArea.'%')
                ->orderBy('orders.id','DESC')
                ->paginate($rpp);
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
        $this->validate($request,[

            "item_id"=>"required", 
            "qty"=>"required|numeric",
            "customer_name"=>"required",
            "add_note"=>"max:100",
            "contact_no"=>"required|max:15",
            "email"=>"email|max:100"
        ]);
 
       try {        
        
            $order = new Order();
            $order->item_id = $request->item_id;
            $order->user_id = $user->id;
            $order->customer_name = $request->customer_name;
            $order->qty = $request->qty;
            $order->add_note = $request->add_note;
            $order->contact_no = $request->contact_no;
            $order->email = $request->email;
            $order->status = 0;
            return $order->save();

       } catch (Exception $ex) {
           return $ex;
       }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
