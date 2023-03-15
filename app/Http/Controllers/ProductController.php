<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponseTraits;

    public function list()
    {
        $query =Product::query();
        $searching_Fields = ['name','price','expired_date'];
        return $this->sendFilterListData($query,$searching_Fields);
    }

    public function create(Request $request)
    {
        $validation = validator($request->all(),[
            'name'              =>  'required|min:3|max:50|unique:products,name',
            'price'             =>  'required|min_digits:1|max_digits:5',
            'expired_date'      =>  'required|date_format:Y-m-d|after_or_equal:'.now(),
            'category_id'       =>  'required|numeric|exists:categories,id',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);

        $product = Product::create($request->only(['name','price','expired_date','category_id']));

        return $this->sendSuccessResponse('Product Added Successfully');

    }

    public function update(Request $request ,$id)
    {
        $validation = validator($request->all(),[
            'name'              =>  'required|min:3|max:50|unique:products,name,'.$id.',id',
            'price'             =>  'required|min_digits:1|max_digits:5',
            'expired_date'      =>  'required|date_format:Y-m-d|after_or_equal:'.now(),
            'category_id'       =>  'required|numeric|exists:categories,id',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);

        
        $product = Product::findOrFail($id);
        $product->update($request->only(['name','price','expired_date','category_id']));

        return $this->sendSuccessResponse('Product Updated Successfully');
    }

    public function get($id)
    {
        $product = Product::with('category','orders')->findOrFail($id);

        return $this->sendSuccessResponse('Product',$product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return $this->sendSuccessResponse('Product Deleted Successfully');
    }
}
