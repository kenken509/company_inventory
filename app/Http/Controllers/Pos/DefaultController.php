<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppliancesCategories;
use App\Models\Appliances;
use App\Models\Brands;

class DefaultController extends Controller
{
    public function GetCategory(Request $request){
        $supplier_id = $request->supplier_id;

        //dd($supplier_id);

        $allCategories = Appliances::with('category')->select('category_id')->where('supplier_id', $supplier_id)->groupBy('category_id')->get();
        //dd($allCategories);

        return response()->json($allCategories);
        
    }// end function

    public function GetProduct(Request $request){
        $category_id = $request->category_id;
        $supplier_id = $request->supplier_id;
        $allProducts = AppliancesCategories::findOrFail($category_id)
                        ->getProducts()
                        ->where('supplier_id',$supplier_id)
                        ->groupBy('product_model')
                        ->get();
        
        //dd($allProducts);
        return response()->json($allProducts);
    }// end function

    public function GetBrands(Request $request){
        $brands = Brands::all();
        
        $allBrands = Appliances::with('getBrand')->select('brand_id')->where('id', $request->product_model)->get();
      
        // foreach($allBrands as $brand){
        //     print_r($brand['getBrand']['name']);
        // }
        return response()->json($allBrands);
    }


}