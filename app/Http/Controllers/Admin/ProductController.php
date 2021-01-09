<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{

    private $productRepository;

    private $categoryRepository;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
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
        $data['categories'] = $this->categoryRepository->allCategories();
        return view('admin.products.create', $data);
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

        $product = $this->productRepository->createProduct($validated);
       
        if (!$product) {
            return redirect(route('products.index'))->with('fail', 'Ürün Oluşturulurken Hata Oluştu');
        }

        //associate product with category
        $this->productRepository->syncProductWithCategory($product->id, $request->productCategoryId ?? []);

        return redirect(route('products.index'))->with('message', 'Ürün Başarıyla Oluşturuldu');
    }

    /**
     * Display the product resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->productRepository->findOrFail($id);
        $selectedCategories = $product->categories->pluck('id');
        $categories =  $this->categoryRepository->allCategories()->whereNotIn('id',$selectedCategories);
        return view('admin.products.show', compact('product','categories'));
    }

    /**
     * Show the form for editing the product resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->productRepository->findOrFail($id);
        $selectedCategories = $product->categories->pluck('id');
        $categories =  $this->categoryRepository->allCategories()->whereNotIn('id',$selectedCategories);
        return view('admin.products.edit', compact('product','categories'));
    }

    /**
     * Update the product resource in storage.
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

        $product = $this->productRepository->updateProduct($id, $validated);
       
        if(!$product){
            return redirect(route('products.index'))->with('fail', 'Ürün Güncellenirken Hata Oluştu');
        }
       
        //associate product with category
        $this->productRepository->syncProductWithCategory($id, $request->productCategoryId ?? []);
       
        return redirect(route('products.index'))->with('message', 'Ürün Başarıyla Güncellendi');
    }

    /**
     * Remove the product resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete associated category with product
        $this->productRepository->syncProductWithCategory($id,[]);
        if (!$this->productRepository->deleteProduct($id)) {
            Cache::flush(); //silinme hatalarında cache temizle 
            return redirect(route('products.index'))->with('fail', 'Ürün Silinirken Hata Oluştu');
        }

        return redirect(route('products.index'))->with('message', 'Ürün Başarıyla Silindi');
    }

}
