<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){

        $orders=Order::query()->where('user_id',auth()->user()->id);

        if(request('status')){
            $orders->where('status',request('status'));
        }

        $orders=$orders->get();

        $pendiente=Order::where('status',1)->where('user_id',auth()->user()->id)->count();
        $recibido=Order::where('status',2)->where('user_id',auth()->user()->id)->count();
        $enviado=Order::where('status',3)->where('user_id',auth()->user()->id)->count();
        $entregado=Order::where('status',4)->where('user_id',auth()->user()->id)->count();
        $anulado=Order::where('status',5)->where('user_id',auth()->user()->id)->count();

        return view('orders.index',compact('orders','pendiente','recibido','enviado','entregado','anulado'));
    }
    public function show(Order $order)
    {
        $this->authorize('author',$order);

        $items = json_decode($order->content);
        return view('orders.show',compact('order','items'));
    }

    public function payment(Order $order)
    {
        $this->authorize('author',$order);

        $items = json_decode($order->content);
        return view('orders.payment', compact('order', 'items'));
    }
}
