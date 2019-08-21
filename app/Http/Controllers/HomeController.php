<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Transactions;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, Transactions $repositoryTransactions)
    {
        $yearSelected = (int) $request->input('year', date('Y'));
        return view('home')->with([
            'months' => $repositoryTransactions->months,
            'yearSelected' => $yearSelected,
            'dataChart' => $repositoryTransactions->chartYear($yearSelected)
        ]);
    }
}
