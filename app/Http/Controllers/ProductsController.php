<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductsResource;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {      
        $products = DB::table('products');
    
    // If search query exists
        if ($request->search) {

            $products = $products->where('product_name', 'LIKE', "%{$request->search}%");
        }

        $products = $products->orderBy('created_at', 'ASC')->paginate(5);

        if ($request->wantsJson()) {
            return ProductsResource::collection($products);
        }

        return view('products.index', [
            'products' => $products
        ]);
    }

    public function getMoreProducts (Request $request) 
    {
        if ( $request->ajax() ) {

            return view('products.pagination_product_page',[
                'products' => DB::table('products')->orderBy('created_at', 'ASC')->paginate(5)
            ])->render();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {

        $imageUniqueName = $this->upload($request);
        $product = DB::table('products')->insert([
            'product_name' => $request->product_name,
            'image' => $imageUniqueName,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'barcode' => $request->barcode,
            'status' => $request->status           
        ]);

        if ( !$product ) {
            
            return redirect()->back()->with('error', 'Sorry, there was a problem while creating product. ');
        }

        return redirect()->back()->withInput()->with('success', 'Success, you have created a new product');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        return response()->json(['product' => DB::table('products')->where('id', $id)->get()]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {   

        $image = $this->upload($request, $id);
        $isUpdated = DB::table('products')
            ->where('id', $id)
            ->update([
                'image' => $image,
                'product_name' => $request->product_name,
                'barcode' => $request->barcode,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'status' => $request->status
            ]);

            return response()->json([
                'action' => $isUpdated ? 'Updated!' : '',
                'messageOnUpdate' => $isUpdated ? 'Product data has been updated.' : '',
                'status' => 'success',
                'data' => DB::table('products')->where('id', $id)->get()
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
        $product = \App\Models\Product::findOrFail($id);
        Storage::delete('public/products/images/' . $product->image);
        $product->delete();

        return response()->json(['message' => 'Success']);
    }


    public function upload ( Request $request, $id = 1 ) {

        $product = \App\Models\Product::find($id);

        if ( $request->has('image') ) {
            
            $file = $request->file('image');
            $fullFileName = $file->getClientOriginalName();
            $fileName = \pathinfo($fullFileName, PATHINFO_FILENAME);
            $fileExtension = $file->extension();
            $newUniqueFileName = $fileName . '_' . time() . '.' . $fileExtension; 
            $pathToStore = $file->storeAs('public/products/images/', $newUniqueFileName);

            return $newUniqueFileName;
        } 

        return $product->image ?? 'no_image.png';
    }


}
