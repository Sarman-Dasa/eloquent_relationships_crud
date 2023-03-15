<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ResponseTraits;

    public function list()
    {
        $query =Order::query();
        $searching_Fields = ['quantity'];
        return $this->sendFilterListData($query,$searching_Fields);
    }

    public function create(Request $request)
    {
        $validation = validator($request->all(),[
            'quantity'      =>  'required|min:1|max:5',
            'product_id'    =>  'required|numeric|exists:products,id',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);

        $order = Order::create($request->only(['quantity','product_id']));

        return $this->sendSuccessResponse('Oder Added Successfully');

    }

    public function update(Request $request ,$id)
    {
        $validation = validator($request->all(),[
            'quantity'      =>  'required|min:1|max:5',
            'product_id'    =>  'required|numeric|exists:products,id',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);
        
        $order = Order::findOrFail($id);
        $order->update($request->only(['quantity','product_id']));

        return $this->sendSuccessResponse('Order Updated Successfully');
    }

    public function get($id)
    {
        $product = Order::with('product','category')->findOrFail($id);

        return $this->sendSuccessResponse('Order',$product);
    }

    public function destroy($id)
    {
        $product = Order::findOrFail($id);
        $product->delete();

        return $this->sendSuccessResponse('Order Deleted Successfully');
    }
}
