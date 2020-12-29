<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $term = $request->s;
        $maxRecordViewLimit = 10; //Maximum number of records show to user

        if ($term) {
            //search as fulltext
            $data['term'] = $term;
            $productPaginate  = Product::whereRaw("MATCH (name) AGAINST (? IN BOOLEAN MODE) OR MATCH (description) AGAINST (? IN BOOLEAN MODE)", array($term, $term))->Paginate($maxRecordViewLimit)->withQueryString();
        } else {
            $productPaginate = Product::Paginate($maxRecordViewLimit)->withQueryString();
        }

        $data['products'] = $productPaginate;

        return view('admin.products.index', $data);
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

        $validated = $request->validate([
            'name' => 'required|unique:products|max:255',
            'description' => 'nullable',
            'price' => 'numeric|nullable',
            'price_new' => 'numeric|nullable',
            'image_alt_text' => 'nullable',
            'tax_type' => 'numeric|nullable',
            'tax' => 'numeric|nullable',
            'image' => 'mimes:jpeg,jpg,png'
        ]);

        if (isset($request->image)) {
            $fileName = $request->image->getClientOriginalName();
            $extension = $request->image->extension(); //.jpg, .png etc...
            $newImageName = pathinfo($fileName, PATHINFO_FILENAME) . "-" . uniqid() . "." . $extension; // output like that : image-321568754.jpg
            $request->image->storeAs('public', $newImageName); //store to folder -> storage/public
            $validated['image'] = $newImageName; //change default name with $newImageName
        }

        Product::create($validated);

        return redirect(route('products.index'))->with('message', 'Ürün Başarıyla Oluşturuldu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['product'] = Product::findOrFail($id);
        return view('admin.products.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['product'] = Product::findOrFail($id);
        return view('admin.products.edit', ['product' => Product::findOrFail($id)]);
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
        $validated = $request->validate([
            'name' => 'required|unique:products|max:255',
            'description' => 'nullable',
            'price' => 'numeric|nullable',
            'price_new' => 'numeric|nullable',
            'image_alt_text' => 'nullable',
            'tax_type' => 'numeric|nullable',
            'tax' => 'numeric|nullable',
            'image' => 'mimes:jpeg,jpg,png'
        ]);

        if (isset($request->image)) {
            $fileName = $request->image->getClientOriginalName();
            $extension = $request->image->extension(); //.jpg, .png etc...
            $newImageName = pathinfo($fileName, PATHINFO_FILENAME) . "-" . uniqid() . "." . $extension; // output like that : image-321568754.jpg
            $request->image->storeAs('public', $newImageName); //store to folder -> storage/public
            $validated['image'] = $newImageName; //change default name with $newImageName
        }

        Product::where('product_id', $id)->update($validated);

        return redirect(route('products.index'))->with('message', 'Ürün Başarıyla Güncellendi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect(route('products.index'))->with('message', 'Ürün Başarıyla Silindi');
    }
}
