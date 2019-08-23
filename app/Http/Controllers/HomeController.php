<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Categories;
use App\Repositories\Transactions;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(
        Request $request,
        Transactions $repositoryTransactions,
        Categories $categoriesRepository
    ) {
        $yearSelected = (int) $request->input('year', date('Y'));

        $yearCurrent = (int) date('Y');
        $monthCurrent = (int) date('m');

        if ($monthCurrent === 1) {
            $lastMonth = 12;
            $lastYear = $yearCurrent-1;
            $nextMonth = 2;
            $nextYear = $yearCurrent;
        } elseif ($monthCurrent === 12) {
            $lastMonth = 11;
            $lastYear = $yearCurrent;
            $nextMonth = 1;
            $nextYear = $yearCurrent+1;
        } else {
            $lastMonth = $monthCurrent-1;
            $lastYear = $yearCurrent;
            $nextMonth = $monthCurrent+1;
            $nextYear = $yearCurrent;
        }

        $last = $monthCurrent-1;
        $next = $monthCurrent+1;
        $lastMonth = ($monthCurrent == 1) ? 12 : $last;
        $nextMonth = ($monthCurrent == 12) ? 1 : $next;

        $yearCurrent = (int) date('y');
        $last = $monthCurrent-1;
        $next = $monthCurrent+1;
        $lastMonth = ($monthCurrent == 1) ? 12 : $last;
        $nextMonth = ($monthCurrent == 12) ? 1 : $next;
        return view('home')->with([
            'months' => $repositoryTransactions->months,
            'yearSelected' => $yearSelected,
            'dataChartAll' => $repositoryTransactions->chartYear($yearSelected),
            'dataChartVerified' => $repositoryTransactions->chartYear($yearSelected, true),
            'donutDataMonthLast' => $repositoryTransactions->donuteChartMonth($lastMonth, $lastYear),
            'donutDataMonth' => $repositoryTransactions->donuteChartMonth($monthCurrent, $yearCurrent),
            'donutDataMonthNext' => $repositoryTransactions->donuteChartMonth($nextMonth, $nextYear),
            'categories' => $categoriesRepository->getToList()
        ]);
    }
}
