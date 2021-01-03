<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;


class ProductController extends Controller
{

    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $term = $request->s;
        if ($term) {
            //if you get some error when try to searching, add name and description table fulltext search 
            $data['term'] = $term;
            $data['products']  = $this->productRepository->paginateProductBySearchingTerm($term);
        } else {
            $data['products'] =  $this->productRepository->paginateProduct();
        }

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
    public function store(ProductRequest $request)
    {

        $validated = $request->validated();

        if (isset($request->image)) {
            $fileName = $request->image->getClientOriginalName();
            $extension = $request->image->extension(); //.jpg, .png etc...
            $newImageName = pathinfo($fileName, PATHINFO_FILENAME) . "-" . uniqid() . "." . $extension; // output like that : image-321568754.jpg
            $request->image->storeAs('public', $newImageName); //store to folder -> storage/public
            $validated['image'] = $newImageName; //change default name with $newImageName
        }

        if(!$this->productRepository->createProduct($validated)){
            return redirect(route('products.index'))->with('fail', 'Ürün Oluşturulurken Hata Oluştu');
        }

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
        $data['product'] = $this->productRepository->findOrFail($id);
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
        $data['product'] = $this->productRepository->findOrFail($id);
        return view('admin.products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $validated = $request->validated();

        if (isset($request->image)) {
            $fileName = $request->image->getClientOriginalName();
            $extension = $request->image->extension(); //.jpg, .png etc...
            $newImageName = pathinfo($fileName, PATHINFO_FILENAME) . "-" . uniqid() . "." . $extension; // output like that : image-321568754.jpg
            $request->image->storeAs('public', $newImageName); //store to folder -> storage/public
            $validated['image'] = $newImageName; //change default name with $newImageName
        }

        $this->productRepository->updateProduct($id, $validated);

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
        if(!$this->productRepository->deleteProduct($id)){
            Cache::flush();//silinme hatalarında cache temizle 
            return redirect(route('products.index'))->with('fail', 'Ürün Silinirken Hata Oluştu');
        }
        return redirect(route('products.index'))->with('message', 'Ürün Başarıyla Silindi');
       
    }
}
