<?php

namespace App\Http\Controllers;
use App\Invoice;
use App\Order;
use App\Setting;
use App\User;
use Carbon\Carbon;
use App\Http\Resources\InvoiceResource;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Http\Resources\SettingResource;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        return InvoiceResource::collection($invoices);
    }
    public function show($id)
    {
        $settings = Setting::findOrFail($id);
        $carbon = new Carbon();
        if($settings->months !== null){
            $items = Order::where('hospital_id' , $id)->where('created_at', '<' , $carbon->Addmonths($settings->months))->where('commission_status' , 0)->get();
        }
        if($settings->order_no !== null){
            $items = Order::where('hospital_id' , $id)->where('commission_status' , 0)->limit($settings->order_no)->get();
        }
        $invoice = Invoice::where('hospital_id' , $id)->firstOrFail();
        $invoice->hospital;

        return response()->json(['invoice' => new InvoiceResource($invoice) ,'items' =>  OrderResource::collection($items) , 'settings' =>  new SettingResource($settings)]);

    }
    public function addItems($item,$id){

        $settings = Setting::findOrFail(1);
        $carbon = new Carbon();
        
        if($settings->months !== null){
            if(Carbon::parse(Carbon::now())->floatDiffInMonths($hospital->created_at) > $settings->months){
                $invoice = new Invoice();
                $invoice->hospital_id = $hospital->id;
                $invoice->url = 'url';
                $invoice->items = $item;
                $invoice->sort = 'فاتورة حجوزات المستشفى لمدة'.$settings->months.'أشهر';
                $invoice->save();
            }else{
                $invoice = Invoice::where('hospital_id', $hospital->id)->firstOrFail();
                $invoice->items = $item;
                $invoice->save();
            }
        }else if($settings->order_no != null){
            if($invoice->items > $settings->order_no){
                $invoice = new Invoice();
                $invoice->hospital_id = $hospital->id;
                $invoice->url = 'url';
                $invoice->items = $item;
                $invoice->sort = 'فاتورة حجوزات المستشفى لعدد'.$settings->order_no.'طلبات';
                $invoice->save();
            }else{
                $invoice = Invoice::where('hospital_id', $hospital->id)->firstOrFail();
                $invoice->items = $item;
                $invoice->save();    
            }
        }


        return response()->json(['invoice' => new InvoiceResource($invoice) ,'items' =>  OrderResource::collection($items) , 'settings' =>  new SettingResource($settings)]);

    }
    
}
