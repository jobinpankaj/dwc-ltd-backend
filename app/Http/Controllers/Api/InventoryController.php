<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public $permisssion;

    public function __construct()
    {
        $headers = getallheaders();
        
        $this->permisssion = isset($headers['permission']) ? $headers['permission'] : "";
    }

    public function inventoryList(Request $request)
    {
        if($this->permisssion !== "inventory-view")
        {
            return sendError('Access Denied', ['error' => Lang::get("messages.not_permitted")], 403);
        }
        
        $user = auth()->user();
        $search = $request->input("search");
        // \DB::enableQueryLog();
        $inventoryQuery = Inventory::query();
        if(!empty($search)) {
            $inventoryQuery->whereHas('product', function($query) use($search){
                $query->where("product_name", "LIKE",  "%$search%");              
            });
        }
        $filterByProductFormat = $request->input("filter_product_format");
        if(!empty($filterByProductFormat)){
            $inventoryQuery->whereHas('product.productFormat', function($query) use($filterByProductFormat){
                $query->where("name", $filterByProductFormat);
            });
        }
        $filterByDistributor = $request->input("filter_distributor");
        if(!empty($filterByDistributor)){
            $inventoryQuery->where('distributor_id', $filterByDistributor);
        }
        $filterBySupplier = $request->input("filter_supplier");
        if(!empty($filterBySupplier)){
            // $inventoryQuery->whereHas('product', function($query) use($filterBySupplier){
            //     $query->where("user_id", $filterBySupplier);
            // });
            $inventoryQuery->where('supplier_id', $filterBySupplier);

        }
        // $inventoryQuery->where('added_by', $user->id)->where('is_visible', 1);
        // $inventoryQuery->select("distributor_id","supplier_id","product_id",\DB::raw("SUM(quantity) as at_warehouse"));
        // $inventoryQuery->with(['distributor','supplierInfo', 'product', 'product.productFormat', 'product.pricing', 'warehouse', 'stocks']);
        // $inventories = $inventoryQuery->groupBy('product_id','distributor_id','supplier_id')->get();
        // dd(\DB::getQueryLog());
        // dd($inventories);
        // $inventories = Inventory::with(['distributor','userProfile','supplierInfo', 'product', 'product.productFormat', 'product.pricing', 'warehouse', 'stocks'])->where('added_by', $user->id)->where('is_visible', 1)->get();
        $inventoryResults = $inventoryQuery->with(['distributor', 'userProfile', 'supplierInfo', 'product', 'product.productFormat', 'product.pricing', 'warehouse', 'stocks'])->where('added_by', $user->id)->where('is_visible', 1)->get();


        $success  = $inventoryResults;
        $message  = Lang::get("messages.inventory_list");
        return sendResponse($success, $message);
    }

    public function getTransferWarehouse(request $request ,$id)
    {
        if($this->permisssion !== "inventory-view")
        {
            return sendError('Access Denied', ['error' => Lang::get("messages.not_permitted")], 403);
        }
        
        $user = auth()->user();
        $search = $request->input("search");
        // \DB::enableQueryLog();
        $inventoryQuery = Inventory::query();
        if(!empty($search)) {
            $inventoryQuery->whereHas('product', function($query) use($search){
                $query->where("product_name", "LIKE",  "%$search%");              
            });
        }
        $filterByProductFormat = $request->input("filter_product_format");
        if(!empty($filterByProductFormat)){
            $inventoryQuery->whereHas('product', function($query) use($filterByProductFormat){
                $query->where("product_format", $filterByProductFormat);
            });
        }
        $filterByDistributor = $request->input("filter_distributor");
        if(!empty($filterByDistributor)){
            $inventoryQuery->where('distributor_id', $filterByDistributor);
        }
        $filterBySupplier = $request->input("filter_supplier");
        if(!empty($filterBySupplier)){
            $inventoryQuery->whereHas('product', function($query) use($filterBySupplier){
                $query->where("user_id", $filterBySupplier);
            });
        }
        // $inventoryQuery->where('added_by', $user->id)->where('is_visible', 1);
        // $inventoryQuery->select("distributor_id","supplier_id","product_id",\DB::raw("SUM(quantity) as at_warehouse"));
        // $inventoryQuery->with(['distributor','supplierInfo', 'product', 'product.productFormat', 'product.pricing', 'warehouse', 'stocks']);
        // $inventories = $inventoryQuery->groupBy('product_id','distributor_id','supplier_id')->get();
        // dd(\DB::getQueryLog());
        // dd($inventories);
        $inventories = Inventory::with(['distributor','supplierInfo', 'product', 'product.productFormat', 'product.pricing', 'warehouse', 'stocks'])->where('added_by', $user->id)->where('is_visible', 1)->where('warehouse_id',$request->id)->get();

        $success  = $inventories;
        $message  = Lang::get("messages.inventory_list");
        return sendResponse($success, $message);
    }

    public function getInventory($id)
    {
        if($this->permisssion !== "inventory-view")
        {
            return sendError('Access Denied', ['error' => Lang::get("messages.not_permitted")], 403);
        }

        $user = auth()->user();
        $inventory = Inventory::with(['distributor', 'supplierInfo', 'product', 'product.productFormat', 'product.pricing', 'warehouse', 'stocks'])->where('added_by', $user->id)->find($id);

        if(!$inventory) {
            return sendError(Lang::get('messages.inventory_not_found'), Lang::get('messages.inventory_not_found'), 404);
        }

        $success = $inventory;
        $message = Lang::get("messages.inventory_detail");
        return sendResponse($success, $message);
    }

    public function addInventory(Request $request)
    {
        if($this->permisssion !== "inventory-edit")
        {
            return sendError('Access Denied', ['error' => Lang::get("messages.not_permitted")], 403);
        }

        $validator = Validator::make($request->all(), [
            'distributor_id' => 'required|numeric|exists:users,id',
            'product_id' => 'required|numeric|exists:products,id',
            'batch' => 'required|string',
            'quantity' => 'required|numeric',
            'warehouse_id' => 'required|numeric|exists:warehouses,id',
            'aisle' => 'required|numeric',
            'shelf' => 'required|numeric',
            'aisle_name' => 'required|string',
            'shelf_name' => 'required|string',
        ]);
        
        if($validator->fails()) {
            return sendError(Lang::get('validation_error'), $validator->errors(), 422);
        }

        $validated = $request->all();
        
        $user = auth()->user();
        $inventory = Inventory::updateOrCreate([
            'added_by' => $user->id,
            'batch' => $validated['batch'],
            'product_id' => $validated['product_id']
        ],[
            'distributor_id' => $validated['distributor_id'],
            'quantity' => $validated['quantity'],
            'warehouse_id' => $validated['warehouse_id'],
            'aisle' => $validated['aisle'],
            'shelf' => $validated['shelf'],
            'aisle_name' => $validated['aisle_name'],
            'shelf_name' => $validated['shelf_name']
        ]);

        $success = $inventory;
        $message = Lang::get("messages.inventory_created_successfully");
        return sendResponse($success, $message);
    }

    public function updateInventory(Request $request, $id)
    {
        if($this->permisssion !== "inventory-edit")
        {
            return sendError('Access Denied', ['error' => Lang::get("messages.not_permitted")], 403);
        }

        $user = auth()->user();
        $inventory = Inventory::where('added_by', $user->id)->find($id);

        if(!$inventory) {
            return sendError(Lang::get('messages.inventory_not_found'), Lang::get('messages.inventory_not_found'), 404);
        }

        $validator = Validator::make($request->all(), [
            'distributor_id' => 'required|numeric|exists:users,id',
            'product_id' => 'required|numeric|exists:products,id',
            'batch' => 'required|string',
            'quantity' => 'required|numeric',
            'warehouse_id' => 'required|numeric|exists:warehouses,id',
            'aisle' => 'required|numeric',
            'shelf' => 'required|numeric',
            'aisle_name' => 'required|string',
            'shelf_name' => 'required|string',
        ]);

        if($validator->fails()) {
            return sendError(Lang::get('validation_error'), $validator->errors(), 422);
        }

        $validated = $request->all();
        
        // Update Inventory
        $inventory->distributor_id = $validated['distributor_id'];
        $inventory->product_id = $validated['product_id'];
        $inventory->batch = $validated['batch'];
        $inventory->quantity = $validated['quantity'];
        $inventory->warehouse_id = $validated['warehouse_id'];
        $inventory->aisle = $validated['aisle'];
        $inventory->shelf = $validated['shelf'];
        $inventory->aisle_name = $validated['aisle_name'];
        $inventory->shelf_name = $validated['shelf_name'];
        
        $inventory->save();

        $success = $inventory;
        $message = Lang::get("messages.inventory_updated_successfully");
        return sendResponse($success, $message);
    }

    public function addInventoryByDistributor(Request $request)
    {
        if($this->permisssion !== "inventory-edit")
        {
            return sendError('Access Denied', ['error' => Lang::get("messages.not_permitted")], 403);
        }

        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|numeric|exists:users,id',
            'batch' => 'required|string',
            'product_id' => 'required|numeric|exists:products,id',
            'quantity' => 'required|numeric',
            'warehouse_id' => 'required|numeric|exists:warehouses,id',
            'aisle' => 'required|numeric',
            'shelf' => 'required|numeric',
            'aisle_name' => 'required|string',
            'shelf_name' => 'required|string',
        ]);
        
        if($validator->fails()) {
            return sendError(Lang::get('validation_error'), $validator->errors(), 422);
        }

        $validated = $request->all();

        $user = auth()->user();
        $inventory = Inventory::updateOrCreate([
            'added_by' => $user->id,
            'batch' => $validated['batch'],
            'product_id' => $validated['product_id'],
        ],[
            'supplier_id' => $validated['supplier_id'],
            'quantity' => $validated['quantity'],
            'warehouse_id' => $validated['warehouse_id'],
            'aisle' => $validated['aisle'],
            'shelf' => $validated['shelf'],
            'aisle_name' => $validated['aisle_name'],
            'shelf_name' => $validated['shelf_name']
        ]);

        $success = $inventory;
        $message = Lang::get("messages.inventory_created_successfully");
        return sendResponse($success, $message);
    }

    public function updateInventoryByDistributor(Request $request, $id)
    {
        if($this->permisssion !== "inventory-edit")
        {
            return sendError('Access Denied', ['error' => Lang::get("messages.not_permitted")], 403);
        }

        $user = auth()->user();
        $inventory = Inventory::where('added_by', $user->id)->find($id);

        if(!$inventory) {
            return sendError(Lang::get('messages.inventory_not_found'), Lang::get('messages.inventory_not_found'), 404);
        }

        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|numeric|exists:users,id',
            'product_id' => 'required|numeric|exists:products,id',
            'batch' => 'required|string',
            'quantity' => 'required|numeric',
            'warehouse_id' => 'required|numeric|exists:warehouses,id',
            'aisle' => 'required|numeric',
            'shelf' => 'required|numeric',
            'aisle_name' => 'required|string',
            'shelf_name' => 'required|string',
        ]);

        if($validator->fails()) {
            return sendError(Lang::get('validation_error'), $validator->errors(), 422);
        }

        $validated = $request->all();
        
        // Update Inventory
        $inventory->supplier_id = $validated['supplier_id'];
        $inventory->product_id = $validated['product_id'];
        $inventory->batch = $validated['batch'];
        $inventory->quantity = $validated['quantity'];
        $inventory->warehouse_id = $validated['warehouse_id'];
        $inventory->aisle = $validated['aisle'];
        $inventory->shelf = $validated['shelf'];
        $inventory->aisle_name = $validated['aisle_name'];
        $inventory->shelf_name = $validated['shelf_name'];
        
        $inventory->save();

        $success = $inventory;
        $message = Lang::get("messages.inventory_updated_successfully");
        return sendResponse($success, $message);
    }

    public function getInventoryProductList()
    {
        if($this->permisssion !== "inventory-view")
        {
            return sendError('Access Denied', ['error' => Lang::get("messages.not_permitted")], 403);
        }
        
        $user = auth()->user();
        $inventories = Inventory::with(['distributor','supplierInfo', 'product', 'warehouse', 'stocks'])->where('added_by', $user->id)->get();

        $inventoryProductData = [];
        foreach($inventories as $item)
        {
            $stockAtWarehouse = $stockDistributorWarehouse = $stockInTransit = $stockDelivery = 0;
            foreach($item->stocks as $itemStock)
            {
                $stockAtWarehouse += $itemStock->at_warehouse;
                $stockDistributorWarehouse += $item->distributor->inventory->stocks->sum('at_warehouse');
                $stockInTransit += $itemStock->in_transit;
                $stockDelivery += $itemStock->delivery;
            }

            $data = [
                'inventory' => [
                    'id' => $item->id
                ],
                'product' => [
                    'id' => $item->product->id,
                    'name' => $item->product->product_name,
                    'producer' => $item->product->userInformation
                ],
                'stocks' => [
                    'at_warehouse' => $stockAtWarehouse,
                    'distributor_warehouse' => $stockDistributorWarehouse,
                    'in_transit' => $stockInTransit,
                    'delivery' => $stockDelivery
                ]
            ];
            array_push($inventoryProductData, $data);
        }

        $success  = $inventoryProductData;
        $message  = Lang::get("messages.inventory_list");
        return sendResponse($success, $message);
    }

    public function hideInventory(Request $request)
    {
        if($this->permisssion !== "inventory-edit")
        {
            return sendError('Access Denied', ['error' => Lang::get("messages.not_permitted")], 403);
        }

        if($request->has('inventories') && !is_array($request->has('inventories'))) {
            return sendError('Validation Error', ['error' => Lang::get("messages.variable_missing")], 422);
        }

        try {
            $user = auth()->user();
            Inventory::where('added_by', $user->id)->whereIn('id', $request->input('inventories'))->update([
                'is_visible' => 0
            ]);

        } catch (Exception $e) {
            return sendError('Server Error', ['error' => Lang::get("messages.something_went_wrong")], 500);
        }

        $success = [];
        $message = Lang::get("messages.inventories_hidden_successfully");
        return sendResponse($success, $message);
    }

    public function getBatchNumberList(Request $request,$product_id)
    {
        if($this->permisssion !== "inventory-edit")
        {
            return sendError('Access Denied', ['error' => Lang::get("messages.not_permitted")], 403);
        }
        $batches = [];
        $user = auth()->user();
        $inventoryListing = Inventory::where("product_id",$product_id);
        if($inventoryListing->count() > 0)
        {
            $batches = $inventoryListing->distinct()->pluck("batch");
        }

        $success["batches"] = $batches;
        $message = Lang::get("messages.batch_listing");
        return sendResponse($success, $message);
    }
}
