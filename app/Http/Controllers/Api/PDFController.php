<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\OrderShipment;
use App\Models\ShipmentOrderItem;
use App\Models\ShipmentTransport;
use App\Models\Product;
use App\Models\Order;
use App\Models\InvoiceDetail;
use PDF;
use Ramsey\Uuid\Uuid;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductFormatDeposit;
use App\Models\Tax;

class PDFController extends Controller
{
    public $permisssion;

    public function __construct()
    {
        $headers = getallheaders();
        
        $this->permisssion = isset($headers['permission']) ? $headers['permission'] : "";
    }
    public function genrateretailepdfrorder(Request $request,$id)
    {
        $user = auth()->user();
       
        $data = Order::with(['items','supplierInformation','retailerInformation','orderShipments','orderDistributors'])->where('id', $id)->first();
        // dd(\DB::getQueryLog());
        $orderItems = $data->items;
    
            // dd($orderItems);
            $totalPrices = [];
            $totalQuantity = [];
            $totalTax = [];
            $totalProductDeposit = [];
            $totalGST = [];
            $totalQST = [];
            $totalGSTQST = [];
            foreach($orderItems as $orderItem)
            {
                $product_format_deposit = ProductFormatDeposit::where('product_format_id',$orderItem->product_format_id)->where('user_id',$user->id)->first();
                if(!empty($product_format_deposit))
                {
                    $prod_deposit = $product_format_deposit->product_format_deposit;
                    
                }
                else{
                    $prod_deposit = 0.0;
                }
                // Extracting data from the "product" object within the order item
                $product = $orderItem['product'];
                // Extracting data from the "pricing" object within the product
                $pricing = $product['pricing'];
                $tax_id = $pricing['tax_id'];
                // $GST = $pricing['tax_amount'] * $orderItem->quantity;
                // $pricegst = $pricing['price'] * $orderItem->quantity;
                if($tax_id == 2)
                {
                    $Tax = Tax::where('id',$tax_id)->first();
                    $GST = ($Tax->tax);
                    // $GST = ($Tax->tax) * $orderItem->quantity;
                    $pricegst = ($orderItem->sub_total) - ($orderItem->tax ?? null);
                    // echo "$pricegst";
                    // $pricegst = $pricing['price'] * $orderItem->quantity;
                    $totalorderGst = ($pricegst * $GST) / 100 ;
                    $totalGST []= $totalorderGst;
                }
                elseif($tax_id == 3)
                {
                    $Tax = Tax::where('id',$tax_id)->first();
                    $QST = ($Tax->tax) ;
              
                    $priceqst = ($orderItem->sub_total) - ($orderItem->tax ?? null);
                  
                    $totalorderQst = ($priceqst * $QST) / 100 ;
                    $totalQST []= $totalorderQst;
                    // dd($totalQST);

                }
                elseif($tax_id == 4)
                {
                    $Tax = Tax::where('id',$tax_id)->first();
                    $GSTQST = ($Tax->tax) ;
                    $pricegstqst = ($orderItem->sub_total) - ($orderItem->tax ?? null);
                    $totalorderGstQst = ($pricegstqst * $GSTQST) / 100 ;
                    $totalGSTQST []= $totalorderGstQst;
                    
                }
                $price = $orderItem->sub_total;
                $quantity = $orderItem->quantity;
                $tax  = $orderItem->tax;
                // Calculate total price for the current order item
                $totalPrice = $price ;
                $totalPrices[] = $totalPrice;
                $totalQuantity[] = $quantity;
                $totalTax[] = $tax;
                $totalProductDeposit [] = $prod_deposit;
                
               

            }
            // dd($totalGST);
            $totalOrderPrice = array_sum($totalPrices);
            $totalOrderQuantity = array_sum($totalQuantity);
            $totalOrderTax = array_sum($totalTax);
            $totalOrderProductDeposit = array_sum($totalProductDeposit);
            $totalOrderGST = array_sum($totalGST);
            
            $totalOrderQST = array_sum($totalQST);
            $totalOrderGSTQST = array_sum($totalGSTQST);
            $subtotal = $totalOrderPrice + $totalOrderProductDeposit;
            // if(!empty($GST))
            // {
            //     dd($pricegst);
            //     $totalorderGstVal = (($pricegst * $GST) * $orderItem->quantity) / 100 ;
            //     dd($totalorderGstVal);
            //     $totalorderGstVal = ($subtotal * $totalOrderGST) / 100 ;
            // }else{
            //     $totalorderGstVal = 0;
            // }
            // if(!empty($QST))
            // {
            //     $totalorderQstVal = (($pricegst * $GST) * $orderItem->quantity) / 100 ;
                
            //     $totalorderQstVal = ($subtotal * $totalOrderQST) / 100 ;
            // }
            // else{
            //     $totalorderQstVal = 0;
            // }
            // if(!empty($GSTQST))
            // {
            //     $totalorderGstQstVal = (($pricegst * $GST) * $orderItem->quantity) / 100 ;

            //     $totalorderGstQstVal = ($subtotal * $totalOrderGSTQST) / 100 ;
            // }else{
            //     $totalorderGstQstVal = 0;
            // }
            // dd($totalorderGstVal);
            $finalPrice = $subtotal + $totalOrderGST   + $totalOrderQST  + $totalOrderGSTQST  ;
            // dd($subtotal);
            // dd($totalProductDeposit);
            $data['totalOrderPrice'] = $totalOrderPrice;
            $data['totalOrderQuantity'] = $totalOrderQuantity;
            // $data['totalOrderTax'] = $totalOrderTax;
            $data['totalOrderProductDeposit'] = $totalOrderProductDeposit;
            $data['totalOrderGST'] = $totalOrderGST;
            $data['totalOrderQST'] = $totalOrderQST;
            $data['totalOrderGSTQST'] = $totalOrderGSTQST;
            $data['subtotal'] = $subtotal;
            $data['finalPrice'] = $finalPrice;
          


            $invoiceId = "$user-"."$data->id".".pdf";
            $file = "file.pdf";
         //   $invoiceNumber = "$userName-"."$invoiceData->invoice_number";
            $dataa['order_info'] = $data;
           
            $pdf = PDF::loadView('pdf/order_info',  $dataa)->save(storage_path('order_info/'.$file));
            $myFile = storage_path('order_info/'.$file);
            return response()->download($myFile);
    }

    public function generatePickupAndDeliveryTicket(Request $request)
    {
        // if($this->permisssion !== "shipment-view")
        // {
        //     return sendError('Access Denied', ['error' => Lang::get("messages.not_permitted")], 403);
        // }
            
        $shipment_id = $request->input("shipment_id");
        $document_type = $request->input("document_type");
        $shipment = Shipment::find($shipment_id);
        if($document_type == "pickup_ticket")
        {
            $transportData = ShipmentTransport::with("orderShipmentsDesc")->whereHas("orderShipmentsDesc")->where("shipment_id",$shipment_id)->get();
            // $transportData = ShipmentTransport::with([
            //     'orderShipmentsDesc' => function ($query) {
            //         $query->with(['shipment' => function ($query) {
            //             $query->with('routeDetail');
            //         }]);
            //     },
            // ])->whereHas("orderShipmentsDesc")->where("shipment_id", $shipment_id)->get();
            
            $data["transportData"] = $transportData;
            // dd($data);
            $name = "pickup-ticket-".$shipment_id."-".time().".pdf";   
            $pdf = PDF::loadView('pdf/pickup-ticket', $data)->save(public_path('storage/pdf_files/'.$name));

            $myFile = storage_path('app/public/pdf_files/'.$name);
            return response()->download($myFile)->deleteFileAfterSend(true);
            return response()->download($myFile);

        }
        else if($document_type == "delivery_ticket")
        {
            $transportData = ShipmentTransport::with("orderShipmentsDesc")->whereHas("orderShipments")->where("shipment_id",$shipment_id)->get();
            // dd($transportData);
            $data["transportData"] = $transportData;
            
            $name = "delivery-ticket-".$shipment_id."-".time().".pdf";
            $pdf = PDF::loadView('pdf/delivery-ticket', $data)->save(public_path('storage/pdf_files/'.$name));

            $myFile = storage_path('app/public/pdf_files/'.$name);
            return response()->download($myFile)->deleteFileAfterSend(true);
            return response()->download($myFile);

        }
    }

    public function downloadProductBarcode(Request $request,$id)
    {
        $product_id = $id;
        $productInfo = Product::find($product_id);
        if($productInfo)
        {
            $name = "barcode-".$product_id."-".time().".pdf";
            $data["productInfo"] = $productInfo;
            $pdf = PDF::loadView('pdf/barcode', $data)->save(public_path('storage/pdf_files/'.$name));

            $myFile = storage_path('app/public/pdf_files/'.$name);
            return response()->download($myFile)->deleteFileAfterSend(true);
        }
    }
    public function creatOrderInvoice(Request $request,$id)
    {
        $order_id = $id;
        $orderInfo = Order::find($order_id);
        $user_id = auth()->user();
        $userName =substr($user_id->first_name, 0,3);
        // dd($check);
        if($orderInfo)
        {
            $orderData = Order::with(['items','supplierInformation','retailerInformation','orderShipments','orderDistributors'])->where('id', $id)->first();
            // dd($orderData);
            $orderItems = $orderData->items;
            // dd($orderItems);
            $totalPrices = [];
            $totalQuantity = [];
            $totalTax = [];
            foreach($orderItems as $orderItem)
            {
                $price = $orderItem->sub_total;
                $quantity = $orderItem->quantity;
                $tax  = $orderItem->tax;
                // Calculate total price for the current order item
                $totalPrice = $price ;
                $totalPrices[] = $totalPrice;
                $totalQuantity[] = $quantity;
                $totalTax[] = $tax;
            }
            $totalOrderPrice = array_sum($totalPrices);
            $totalOrderQuantity = array_sum($totalQuantity);
            $totalOrderTax = array_sum($totalTax);
            $invoiceDat = InvoiceDetail::where('created_by',$user_id->id)->latest()->first();
            // dd($invoiceDat);
            // if(!empty($invoiceData))
            // {
            //     $invoiceData->update(['invoice_number' => $invoiceData->invoice_number + 1]);
            // }
            
            // $orderRefrenceNumber = substr($orderData->order_reference,12);
            $orderRefrenceNumber = $request->invoice_no;
            $invoiceData = new InvoiceDetail();
            $invoiceData->created_by = $user_id->id;
            if(!empty($invoiceDat))
            {
                $invoiceData->invoice_number = $invoiceDat->invoice_number +1;
            }
            else{
                $invoiceData->invoice_number = $orderRefrenceNumber;

            }
            $invoiceData->order_id = $order_id;
            $invoiceData->save();
            $invoiceId = "$userName-"."$invoiceData->invoice_number".".pdf";
            $invoiceNumber = "$userName-"."$invoiceData->invoice_number";
            $data["orderData"] = $orderData;
            $data['invoiceNumber'] = $invoiceNumber;
            $data['totalOrderTax'] = $totalOrderTax;
            $pdf = PDF::loadView('invoices/order-invoice', $data)->save(public_path('storage/order_invoices/'.$invoiceId));

            $myFile = storage_path('app/public/order_invoices/'.$invoiceId);
            return response()->download($myFile);
        }
    }
    public function getInvoiceList(request $request)
    {
        $user_id = auth()->user()->id;
        $invoiceList = InvoiceDetail::where('created_by',$user_id)->orwhere('created_for',$user_id)->get();
        $success  = $invoiceList;
        $message  = Lang::get("InvoiceList");
        return sendResponse($success, $message);
    }
}
