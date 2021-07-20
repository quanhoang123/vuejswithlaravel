<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=Product::orderBy('id', 'DESC')->get();
        return $product;
    }

    public function getType(){
        $loai = ProductType::all();
        return $loai;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:255',
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'promotion_price' => 'required',
            'description' => 'required',
            'unit_price' => 'required',
            'new' => 'required',
            'id_type' => 'required',
        ], [
            'required' => ':attribute Không được để trống',
            'min' => ':attribute Không được nhỏ hơn :min',
            'max' => ':attribute Không được lớn hơn :max',
            'image'=>':attribute Phải đúng định dạng và không lớn hơn 1'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->getMessageBag(),
                'status' => 0,
            ]);
        } else {
            $product = new Product();
            if($request->hasFile('image')){
                $file=$request->file('image');
                $file_name=$file->getClientOriginalName('image');
                $file->move('images/',$file_name);
                // $product->image=$file_name;
            }
            if($request->file('image')!=null){      
                $product->image=$file_name;
            }else{
                $product->image="hihih";
            }
            $product->name = $request->name;
            $product->description = $request->description;
            $product->unit_price = $request->unit_price;
            $product->promotion_price = $request->promotion_price;
            $product->unit = $request->unit;
            $product->new = $request->new;
            $product->id_type = $request->id_type;  
            $product->save();
            if($product !=null){
                return response()->json([
                    'message'=>'Product Created Successfully!!',
                    'product'=>$product,
                    'status'=>200,
                ]);
            }
            else{
                return response()->json([
                    'message'=>'San Pham Khong Duoc Tao',
                    'product'=>$product,
                    'status' => 100,
                ]);
            }
           
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        
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
        

        $product=Product::findOrFail($id);
        if($request->hasFile('image')){
            $file=$request->file('image');
            $file_name=$file->getClientOriginalName('image');
            $file->move('images/',$file_name);
        }
        if($request->file('image')!=null){      
            $product->image=$file_name;
        }else{
            $product->image="hihih";
        }
        $product->name = $request->name;
        $product->description = $request->description;
        $product->unit_price = $request->unit_price;
        $product->promotion_price = $request->promotion_price;
        $product->unit = $request->unit;
        $product->new = $request->new;
        $product->id_type = $request->id_type;  
        $product->save();
        return response()->json([
            'message'=>'Product Created Successfully!!',
            'product'=>$product
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
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'message'=>'Product Deleted Successfully!!'
        ]);     
    }
}
