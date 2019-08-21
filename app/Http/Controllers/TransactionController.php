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
        $searchMonth = $request->input('search_month', '');
        $searchYear = $request->input('search_year', '');
        $searchVerified = $request->input('search_is_verified', '');
        $searchType = $request->input('search_type', '');
        $where = [
            'month' => $searchMonth,
            'year' => $searchYear,
            'type' => $searchType,
            'is_verified' => $searchVerified
        ];
        return view('transactions.list')->with([
            'data' => $repository->getToList($where),
            'months' => $repository->months,
            'search_month' => $searchMonth,
            'search_year' => $searchYear,
            'search_is_verified' => $searchVerified,
            'search_type' => $searchType,
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
