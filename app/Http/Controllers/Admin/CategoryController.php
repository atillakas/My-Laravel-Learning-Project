<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
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
            $data['categories']  = $this->categoryRepository->paginateCategoryBySearchingTerm($term);
        } else {
            $data['categories'] =  $this->categoryRepository->paginateCategory();
        }

        return view('admin.categories.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = $this->categoryRepository->allCategories() ?? [];

        return view('admin.categories.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();

        if (isset($request->image)) {
            $fileName = $request->image->getClientOriginalName();
            $extension = $request->image->extension(); //.jpg, .png etc...
            $newImageName = pathinfo($fileName, PATHINFO_FILENAME) . "-" . uniqid() . "." . $extension; // output like that : image-321568754.jpg
            $request->image->storeAs('public', $newImageName); //store to folder -> storage/public
            $validated['image'] = $newImageName; //change default name with $newImageName
        }

        if (!$this->categoryRepository->createCategory($validated)) {
            return redirect(route('categories.index'))->with('fail', 'Kategori Oluşturulurken Hata Oluştu');
        }

        return redirect(route('categories.index'))->with('message', 'Kategori Başarıyla Oluşturuldu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['categories'] = $this->categoryRepository->orWhereNotDescendantOf($id);
        $data['category'] = $this->categoryRepository->findOrFail($id);
        return view('admin.categories.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['categories'] = $this->categoryRepository->orWhereNotDescendantOf($id);
        $data['category'] = $this->categoryRepository->findOrFail($id);
        return view('admin.categories.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $validated = $request->validated();

        if (isset($request->image)) {
            $fileName = $request->image->getClientOriginalName();
            $extension = $request->image->extension(); //.jpg, .png etc...
            $newImageName = pathinfo($fileName, PATHINFO_FILENAME) . "-" . uniqid() . "." . $extension; // output like that : image-321568754.jpg
            $request->image->storeAs('public', $newImageName); //store to folder -> storage/public
            $validated['image'] = $newImageName; //change default name with $newImageName
        }

        if (!$this->categoryRepository->updateCategory($id, $validated)) {
            return redirect(route('categories.index'))->with('fail', 'Kategori Oluşturulurken Hata Oluştu');
        }

        return redirect(route('categories.index'))->with('message', 'Kategori Başarıyla Oluşturuldu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->categoryRepository->deleteCategory($id)) {
            return redirect(route('categories.index'))->with('message', 'Kategori Başarıyla Silindi');
        }

        return redirect(route('categories.index'))->with('message', 'Kategori Silinirken Kırılma Meydana Geldi Bütünlüğü Kontrol Edin.');
    }
}