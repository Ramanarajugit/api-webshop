<?php

namespace App\Http\Controllers\Api;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderProducts;
class OrdersController extends Controller
{
    /**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index()
{


$orders = Orders::all();

return response()->json([
"success" => true,
"message" => "Orders List",
"data" => $orders
]);
}

/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{

$orders = json_decode($request->getContent(), true);

$data = Orders::create([
    'is_pay' => $orders['is_pay'],
    'customers_id' => $orders['customers_id']
 ]);



foreach($orders['products'] as $product){

    OrderProducts::create([
        'products_id' => $product['products_id'],
        'orders_id' => $data->id
     ]);
   
}

return response()->json([
"success" => true,
"message" => "Order created successfully.",
"data" => $data
]);

} 
/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
$orders = Orders::find($id);
if (is_null($orders)) {
return $this->sendError('Order not found.');
}
return response()->json([
"success" => true,
"message" => "Order retrieved successfully.",
"data" => $orders
]);
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
    $orders = json_decode($request->getContent(), true);
 
    $order = Orders::find($id);   
    $order->is_pay = $orders['is_pay'];
    $order->save();

    $orderproducts = OrderProducts::where('id',$id)->get();
    
    foreach($orders['products'] as $product){

        OrderProducts::create([
            'products_id' => $product['products_id'],
            'orders_id' => $id
         ]);
       
    }

    return response()->json([
    "success" => true,
    "message" => "Order updated successfully.",
    "data" => $order
    ]);
}
/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
   
$order = Orders::find($id);
$order->delete();
return response()->json([
"success" => true,
"message" => "Order deleted successfully.",
"data" => $order
]);
}
}
