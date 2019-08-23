<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Categories;
use App\Repositories\Transactions;
use App\Http\Requests\TransactionStore;
use App\Http\Requests\TransactionDelete;
use App\Http\Requests\TransactionVerify;

class TransactionController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(
        Request $request,
        Transactions $repository,
        Categories $categoriesRepository
    ) {
        $searchMonth = $request->input('search_month', date('m'));
        $searchYear = $request->input('search_year', date('Y'));
        $searchVerified = $request->input('search_is_verified', '');
        $searchType = $request->input('search_type', '');
        $searchCategoryId = $request->input('search_category_id', '');
        $where = [
            'month' => $searchMonth,
            'year' => $searchYear,
            'type' => $searchType,
            'is_verified' => $searchVerified,
            'category_id' => $searchCategoryId
        ];
        $data = $repository->getToList($where);
        return view('transactions.list')->with([
            'data' => $data['list'],
            'totals' => $data['totals'],
            'months' => $repository->months,
            'search_month' => $searchMonth,
            'search_year' => $searchYear,
            'search_is_verified' => $searchVerified,
            'search_type' => $searchType,
            'search_category_id' => $searchCategoryId,
            'categories' => $categoriesRepository->getToList()
        ]);
    }

    public function store(TransactionStore $request, Transactions $repository)
    {
        $repository->save($request->all());
        return redirect()->back();
    }

    public function delete(TransactionDelete $request, Transactions $repository, $id)
    {
        $repository->delete($id);
        return redirect()->back();
    }

    public function verify(TransactionVerify $request, Transactions $repository, $id)
    {
        $repository->verify($id);
        return redirect()->back();
    }
}
