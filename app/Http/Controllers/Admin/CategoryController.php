<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Category;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}



// $data = [
//     'id' => 9,
//     'name' => 'Foo',
//     'children' => [
//         [
//             'id' => 10,
//             'name' => 'Bar',
//         ],
//     ],
//     'children' => [
//         [
//             'id' => 11,
//             'name' => 'Baz',
//         ],
//     ],
// ];
// $data2 = [
//     'id' => 9,
//     'name' => 'Ayakkabı',
//     'children' => [
//         [
//             'id' => 10,
//             'name' => 'Babet',
//         ],
//         [
//             'id' => 11,
//             'name' => 'Kundura',
//         ],
//     ],
// ];

// // dd(Category::create($data2));
// Category::fixTree();
// $nodes = Category::get()->toFlatTree();

// foreach ($nodes as $category) {
//     $result = Category::defaultOrder()->ancestorsAndSelf($category->id)->toArray();
//     $breadCrumb = implode(">", array_column($result, "name"));
//     echo $breadCrumb ."<br>";
// }

// // $traverse = function ($categories, $prefix = '-') use (&$traverse) {
// //     foreach ($categories as $category) {

// //         echo PHP_EOL . $prefix . ' ' . $category->name. "<br>";

// //         $traverse($category->children, $prefix . '-');
// //     }
// // };

// // $traverse($nodes);


// // var_dump(Category::isBroken());
// // var_dump(Category::countErrors());
