<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ResponseTraits;

    public function list()
    {
        $query = Category::query();
        $searching_Fields = ['name','description'];
        return $this->sendFilterListData($query,$searching_Fields);
    }

    public function create(Request $request)
    {
        $validation = validator($request->all(),[
            'name'          =>  'required|min:3|max:50|unique:categories,name',
            'description'   =>  'required|min:5|max:100',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);

        $category = Category::create($request->only(['name','description']));

        return $this->sendSuccessResponse('Category Added Successfully');

    }

    public function update(Request $request ,$id)
    {
        $validation = validator($request->all(),[
            'name'          =>  'required|min:3|max:50|unique:categories,name,'.$id.',id',
            'description'   =>  'required|min:5|max:100',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);
        
        $category = Category::findOrFail($id);
        $category->update($request->only(['name','description']));

        return $this->sendSuccessResponse('Category Updated Successfully');
    }

    public function get($id)
    {
       // $category = Category::with('products','orders')->findOrFail($id);
        $category = Category::with('products','orders')->withCount('products','orders')->withSum('products','price')->withMin('products','price')->findOrFail($id);
        return $this->sendSuccessResponse('Category',$category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        
        return $this->sendSuccessResponse('Category',$category);
    }
}
