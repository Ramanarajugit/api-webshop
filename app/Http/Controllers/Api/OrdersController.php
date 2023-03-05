<?php

namespace App\Http\Controllers\Api;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderProducts;
use App\Http\Resources\OrderResource;
use App\Http\Controllers\Api\BaseController as BaseController;
class OrdersController extends BaseController
{
    /**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index()
{
    $orders = Orders::all();
    return $this->sendResponse(OrderResource::collection($orders), 'Orders Retrieved Successfully.');

}

/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{

    $input = $request->all();
   
    $validator = Validator::make($input, [
        'customers_id' => 'required',
        'is_pay' => 'required'
    ]);

    if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());       
    }

    $orders = Orders::create($input);

    foreach($input['products'] as $product){

        OrderProducts::create([
            'products_id' => $product['products_id'],
            'orders_id' => $orders->id
         ]);
       
    }

    return $this->sendResponse(new OrderResource($orders), 'Order Created Successfully.');


} 
/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
    if (Orders::where('id', $id)->exists()) {
    $orders = Orders::find($id);
  
    if (is_null($orders)) {
        return $this->sendError('Order not found.');
    }

    return $this->sendResponse(new OrderResource($orders), 'Order Retrieved Successfully.');
    }else{

        return $this->sendError('Order not found.');
    }  
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function update(Request $request,$id)
{
    if (Orders::where('id', $id)->exists()) {
    $input = $request->all();
   
    $validator = Validator::make($input, [
        'is_pay' => 'required'
    ]);

    if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());       
    }
    $orders = Orders::find($id);   
    $orders->is_pay = $input['is_pay'];
    $orders->save();

    $orderproducts = OrderProducts::find($id);
    $orderproducts->delete();
    
    
    foreach($input['products'] as $product){

        OrderProducts::create([
            'products_id' => $product['products_id'],
            'orders_id' => $id
         ]);
       
    }

   return $this->sendResponse(new OrderResource($orders), 'Order Updated Successfully.');
    }else{

        return $this->sendError('Order not found.');
    }  
}
/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
    if (Orders::where('id', $id)->exists()) {
    $orders = Orders::find($id);
    $orders->delete();

    return $this->sendResponse(200, 'Order Deleted Successfully.');

    }else{

        return $this->sendError('Order not found.');
    }    
}
}
