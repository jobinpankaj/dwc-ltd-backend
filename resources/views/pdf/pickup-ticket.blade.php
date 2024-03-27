<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup-Menifest</title>
</head>

<body>
    <div style="width:700px; margin: 0 auto; padding: 20px 0px;">
            <?php
            foreach($transportData as $transportData){ ?>
            
        <table colspan="0" rowspan="0" style="width: 100%; font-family:'Ubuntu', sans-serif;margin-bottom:30px">
            <thead>
                <tr>
                    <th style="font-size: 22px; color: #414141; text-align: start; padding-bottom: 15px;">Pick up
                        Manifest</th>
                    <th style=" text-align: end; font-size: 20px; font-weight: 400; padding-bottom: 15px;">
                        <img src="./images/route-img.jpg" alt="route"
                            style="vertical-align: bottom; padding-right: 5px;">
                        <strong style="font-weight: 700;">Route</strong> : {{$transportData->shipmentInformation->routeDetail->name}}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" style="    
                    background-color: #8154dd;
                    color: #fff;
                    border-radius: 8px;
                    -moz-border-radius: 8px;
                    -webkit-border-radius: 8px; ">
                        <table colspan="0" rowspan="0" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td colspan="4" style="padding: 10px;">
                                        <div style="display: table;">
                                            <div style="display: table-cell;"><img src="./images/delivery-van.jpg"
                                                    alt="" style="vertical-align: top; padding: 0 10px 0 0;"></div>
                                            <div style="display: table-cell;">
                                                <h3 style="margin:0 0 5px; line-height: 1;">
                                                    <strong>Transport</strong> {{ $transportData->id }}</h3>
                                                <p style="margin:5px 0 0; line-height: 1;">Driver : <strong>{{ $transportData->name }}</strong></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td colspan="2"> &nbsp;</td>
                                    <td
                                        style="font-size: 13px; text-align: center; border-right: 1px solid #9370db; width: auto; padding: 10px 5px;">
                                        <span
                                            style="margin: auto;display: table; background: #713fd8 !important;font-size: 13px; font-weight:600; padding: 8px 10px; border-radius: 20px;">#Retailer</span>
                                        <span style="padding-top: 5px;  display: table;width: 100%;">{{ $transportData->orderShipmentsDesc->pluck('shipmentOrderItems.*.orderItems.order.retailer_id')->unique()->count() }}</span>
                                    </td>
                                    <td
                                        style="font-size: 13px; text-align: center; border-right: 1px solid #9370db; width: auto; padding: 10px 5px;">
                                        <span
                                            style="margin: auto;display: table; background: #713fd8 !important;font-size: 13px; font-weight:600; padding: 8px 10px; border-radius: 20px;">#
                                            Orders</span>
                                        <span style="padding-top: 5px;  display: table;width: 100%;">{{ $transportData->orderShipmentsDesc->sum(function ($orderShipment) {
                                return $orderShipment->shipmentOrderItems->count();
                            }) }}</span>
                                    </td>
                                    <td
                                        style="font-size: 13px; text-align: center; border-right: 1px solid #9370db; width: auto; padding: 10px 5px;">
                                        <span
                                            style="margin: auto;display: table; background: #713fd8 !important;font-size: 13px; font-weight:600; padding: 8px 10px; border-radius: 20px;">#
                                            Pallets</span>
                                        <span style="padding-top: 5px;  display: table;width: 100%;">15</span>
                                    </td>
                                    <td
                                        style="font-size: 13px; text-align: center; border-right: 1px solid #9370db; width: auto; padding: 10px 5px;">
                                        <span
                                            style="margin: auto;display: table; background: #713fd8 !important;font-size: 13px; font-weight:600; padding: 8px 10px; border-radius: 20px;">#
                                            Boxes</span>
                                        <span style="padding-top: 5px;  display: table;width: 100%;">15</span>
                                    </td>
                                    <td style="font-size: 13px; text-align: center; width: auto;padding: 10px 5px;">
                                        <span
                                            style="margin: auto;display: table; background: #713fd8 !important;font-size: 13px; font-weight:600; padding: 8px 10px; border-radius: 20px;">#
                                            Kegs</span>
                                        <span style="padding-top: 5px;  display: table;width: 100%;">15</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border:1px solid #cecece; border-radius: 5px;padding: 10px 0 0;">
                        <table colspan="0" rowspan="0"
                            style="color:#333;  text-align: center;  border-spacing: 0; font-size: 13px;font-weight: 500;text-transform: capitalize;line-height: 1.4; width: 100%;">
                            <thead>
                                <tr>
                                    <th
                                        style="background: #a67df9;color:#fff; padding:10px 5px; border-top-left-radius: 10px;">
                                        S. No.</th>
                                    <th style="background: #a67df9;color:#fff;padding:10px 5px;"> Order No.</th>
                                    <th style="background: #a67df9;color:#fff;padding:10px 5px;">Retailer Name</th>

                                     <th style="background: #a67df9;color:#fff;padding:10px 5px;"> Product Style</th>
                                     
                                    <th style="background: #a67df9;color:#fff; padding:10px 5px;">Product Type</th>
                                    <th style="background: #a67df9;color:#fff;">Product Format</th> 
                                     <th style="background: #a67df9;color:#fff; padding:10px 5px;">Batch Number</th>
                                    <th style="background: #a67df9;color:#fff; padding:10px 5px;">Aisle Name</th>
                                    <th style="background: #a67df9;color:#fff; padding:10px 5px;">Self Name</th>
                                    <th
                                        style="background: #a67df9;color:#fff; padding:10px 5px;  border-top-right-radius: 10px;">
                                        Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $i = 1; 
                            foreach($transportData->orderShipmentsDesc as $orderShipment){
                                // dd($transportData->shipmentInformation->routeDetail->name);
                            foreach($orderShipment->shipmentOrderItems as $shipmentOrderItem) { ?>
                            
                                 <tr>
                                    <td><?=$i++;?></td>
                                    <td><?=$shipmentOrderItem->orderItems->order->order_reference; ?></td>
                                    <td><?=$shipmentOrderItem->orderItems->order->retailerInformation->full_name; ?></td>
                                    <td><?=$shipmentOrderItem->orderItems->product->productStyle->name; ?></td>
                                    <td><?=$shipmentOrderItem->orderItems->product->product_type; ?></td>
                                    <td><?=$shipmentOrderItem->orderItems->product->productFormat->name; ?></td>
                                    <td><?=$shipmentOrderItem->batch_number; ?></td>
                                    <td><?=$shipmentOrderItem->aisle_name; ?></td>
                                    <td><?=$shipmentOrderItem->shelf_name; ?></td>
                                    <td><?=$shipmentOrderItem->shipped_quantity; ?></td>
                                </tr>
                               
                                <?php  }}?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                
            </tbody>
        </table>
        <?php } ?>

    </div>
</body>

</html>