<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $products;

    public function __construct(Product $products)
    {
        // $this->middleware('auth');
        return $this->products = $products;

    }


    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', ['products' => $products]);
    }

    public function productOfferStart()
    {
        return view('admin.last-prices.starting-offer');
    }

    public function productOfferEnd()
    {
        return view('admin.last-prices.ending-offer');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $createProduct = Product::create($request->except('_token'));
        $createProduct['ending_date'] = Carbon::parse($createProduct['ending_date'])->format('Y-m-d H:i:s');

        return $this->createData($createProduct, 'Product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data = Product::where('id', $id)->first();

        unlink(public_path('images/'.$data->image));

        $uploaded_file =$request->file()['image']->getClientOriginalName();
        $file_name = time().$uploaded_file;
        $request->image->move(public_path('images'), $file_name);
        $datas = [
            'name' => $request->input('name'),
            'image' => $file_name,
            'starter_price' => $request->input('starter_price'),
            'ending_date' => $request->input('ending_date')
        ];
        // dd($data);
        $updateData = Product::where('id', $id)->update($datas);

        return $this->updateData($updateData, 'Product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteProduct = Product::find($id);

        if(file_exists($deleteProduct->image))
        {
            unlink(public_path('images\\'.$deleteProduct->image));
        }
        return $this->deleteData($deleteProduct, $this->products, $id, 'Product');
    }
}
