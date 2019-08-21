<?php

namespace App\Http\Controllers;

use App\Repositories\Categories;
use App\Http\Requests\CategoryStore;
use App\Http\Requests\CategoryDelete;

class CategoryController extends Controller
{

    /**
     * Show list categories.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Categories $repository)
    {
        return view('categories.list')->with('data', $repository->getToList());
    }

    public function store(CategoryStore $request, Categories $repository)
    {
        $repository->save($request->all());
        return redirect('categories');
    }

    public function delete(CategoryDelete $request, Categories $repository, $id)
    {
        $repository->delete($id);
        return redirect('categories');
    }

}
